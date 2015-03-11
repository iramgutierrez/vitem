<?php 

//use Vitem\Repositories\PermissionRepo;

class Record extends Eloquent {	

	protected $fillable = ['user_id' , 'type' , 'entity' , 'entity_id' , 'message' , 'object'];

    protected $appends = ['unix_time' ,'object_array' ];

    public function User()
    {
        return $this->belongsTo('User', 'user_id' ,'id');
    }

	public function getUnixTimeAttribute()
    {
        if($this->created_at)
        {//Si la variable $fecha es null se le asigna valor
        
            $date = $this->created_at;
            //Se explota la fecha
            $date = explode(" ",$date);

            $time = $date[1];

            $date = $date[0];

            $time = explode(":",$time);

            $date = explode("-",$date);
            //Se obtiene la fecha en formato timestamp
            $unix = mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
            //Se devuelve el valor
            return $unix;

        }
    }

    public function getObjectArrayAttribute()
    {
    
    	return json_decode($this->object , true);

    }


}