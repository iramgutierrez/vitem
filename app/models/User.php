<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

	protected $fillable = [
			'username', 
			'email' , 
			'password' , 
			'name' , 
			'street',
			'outer_number',
			'inner_number',
			'zip_code',
			'colony',
			'city',
			'state',
			'phone' , 
			'role_id' ,
			'image_profile'
			];

	protected $dates = ['deleted_at'];
	
    protected $appends = ['url_show' , 'url_edit' ,  'url_delete' , 'image_profile_url' ];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	    

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function Employee()
    {
        return $this->hasOne('Employee', 'users_id', 'id');
    }

    public function Role()
    {
        return $this->belongsTo('Role');
    }

	public function commissions()
	{
		return $this->hasMany('Commission');
	}

	public function deliveries()
	{
		return $this->hasMany('Delivery');
	}

     public function setPasswordAttribute($value)
    {
        if ( ! empty ($value))
        {
            $this->attributes['password'] = \Hash::make($value);
        }
    }

    public function getUrlShowAttribute()
	{
	    return URL::route('users.show', [$this->id]);
	}

    public function getUrlEditAttribute()
	{
	    return URL::route('users.edit', [$this->id]);
	}	

    public function getUrlDeleteAttribute()
	{
	    return URL::route('users.destroy', [$this->id]);
	}

	public function getImageProfileUrlAttribute()
	{
		$image = ($this->image_profile) ?  $this->image_profile : 'default.jpg';
		return URL::asset('images_profile/'. $image);
	}

	public static function boot()
    {
        parent::boot();

        static::created(function($user)
        {
        	$user->Employee; 
        	$user->Role;
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 1,
				'entity' => 'User',
				'entity_id' => $user->id,
				'message' => 'agregó el usuario '.$user->name,
				'object' => $user->toJson()

			]);
        });

        static::updated(function($user)
        {
        	$user->Employee; 
        	$user->Role;
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 3,
				'entity' => 'User',
				'entity_id' => $user->id,
				'message' => 'editó el usuario '.$user->name,
				'object' => $user->toJson()

			]);
        });        

        static::deleted(function($user)
        {
        	$user->Employee; 
        	$user->Role;
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 4,
				'entity' => 'User',
				'entity_id' => $user->id,
				'message' => 'eliminó el usuario '.$user->name,
				'object' => $user->toJson()

			]);
        });

    }

}
