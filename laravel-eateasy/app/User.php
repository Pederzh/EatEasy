<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password','esercente'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->token = str_random(30);
        });
    }

    /**
     * Set the password attribute.
     *
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Confirm the user.
     *
     * @return void
     */
    public function confirmEmail()
    {
        $this->verified = true;
        $this->token = null;

        $this->save();
    }

    /* ritorna un'istanza del model "DatiEsercente" in relazione allo User */
    public function datiEsercente()
    {
        return $this->hasOne('App\DatiEsercente','ID_esercente');
    }

    /* ritorna un'istanza del model "DatiUtente" in relazione allo User */
    public function datiUtente()
    {
        return $this->hasOne('App\DatiUtente','ID_utente');
    }

    /* ritorna "true" se lo User è un esercente, altrimenti "false" */
    public function isEsercente()
    {
        if ($this->attributes['esercente'] == 1)
            return true;
        else
            return false;
    }

    /* ritorna true se è il primo accesso */
    public function firstAccess()
    {
        if ($this->attributes['accessi'] == 1)
            return true;
        else
            return false;
    }

    /* quando chiamata incrementa il numero degli accessi */
    public function incAccessi()
    {
        $this->attributes['accessi'] += 1;
        $this->save();
    }
}
