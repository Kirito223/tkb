<?php

namespace App;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;
    protected $table = 'tbl_admin';
    protected $fillable = [
    	'tentaikhoan', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	'password', 'remember_token',
    ];

    public function roles()
    {
      return $this->belongsToMany(Role::class);
  }

  public function users()
  {
      return $this->belongsToMany(User::class);
  }




//check nếu người dùng không thoả mãn quyền thì bắn ra exception, dùng cách này sau này ta sẽ render ra trang thông báo lỗi cho người dùng, tham số nhận vào array hoặc string
public function authorizeRoles($roles)
{
  if (is_array($roles)) {
      return $this->hasAnyRole($roles) || 
      abort(401, 'This action is unauthorized.');
  }
  return $this->hasRole($roles) || 
  abort(401, 'This action is unauthorized.');
}

//check nếu người dùng có một trong các quyền, tham số nhận vào array
public function hasAnyRole($roles)
{
  return null !== $this->roles()->whereIn(‘name’, $roles)->first();
}

//phương thức này để check nếu như người dùng có 1 quyền nào đó, tham số nhận vào string
public function hasRole($role)
{
  return null !== $this->roles()->where(‘name’, $role)->first();
}

}
