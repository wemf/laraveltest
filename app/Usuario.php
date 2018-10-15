<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\UsuarioResetPasswordNotification;
use App\Models\autenticacion\Role;
use App\Models\autenticacion\Funcionalidad;
use App\Models\autenticacion\RoleFuncionalidad;
use Illuminate\Support\Facades\Cache;
use Laravel\Passport\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens,Notifiable;

    protected $table='tbl_usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'verify_token',
        'id_role',
        'estado',
        'modo_ingreso'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ]; 

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function inrole()
    {
        return $this->hasMany(RoleFuncionalidad::class, 'id_role', 'id_role')->join('tbl_usuario_funcionalidad', 'id_funcionalidad', '=', 'id');
    }       
      
    public function inFuncionalidad($fu)
    {    
        return $this->hasMany(RoleFuncionalidad::class, 'id_role', 'id_role')
                    ->join('tbl_usuario_funcionalidad', 'id_funcionalidad', '=', 'id')
                    ->where('codigo',$fu)->count(); 
    }

    /*$fu-> array*/
    public function inFuncionalidades($fu)
    {
        return $this->hasMany(RoleFuncionalidad::class, 'id_role', 'id_role')
                    ->join('tbl_usuario_funcionalidad', 'id_funcionalidad', '=', 'id')
                    ->whereIn('codigo',$fu)->count(); 
    }
    
  	

     /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UsuarioResetPasswordNotification($token));
    }

    public function isOnline() {
        
        return Cache::has('user-online-' .$this->id);

    }
}
