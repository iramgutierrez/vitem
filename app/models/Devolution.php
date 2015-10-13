<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;


class Devolution extends \Eloquent {

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

	protected $fillable = ['devolution_date' , 'status_pay','supplier_id' , 'user_id' , 'total' ];

    protected $appends = ['url_show' , 'url_edit' ,  'url_delete' ];

	public function products()
    {
        return $this->belongsToMany('Product', 'devolution_product')->withPivot(['quantity' , 'status']);
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function supplier()
    {
        return $this->belongsTo('Supplier');
    }

    public function getUrlShowAttribute()
    {
        return URL::route('devolutions.show', [$this->id]);
    }

    public function getUrlEditAttribute()
    {
        return URL::route('devolutions.edit', [$this->id]);
    }

    public function getUrlDeleteAttribute()
    {
        return URL::route('devolutions.destroy', [$this->id]);
    }

    public static function boot()
    {
        parent::boot();

        /*static::created(function($devolution)
        {
            if($devolution->status_pay == 'pagado')
            {
                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'type' => 'in',
                    'entity' => 'Devolution',
                    'entity_id' => $devolution->id,
                    'total' => $devolution->total,
                    'date' => date('Y-m-d H:i:s')
                ]);

            }
        });

        static::updated(function($devolution)
        {

            if($devolution->status_pay == 'pagado')
            {
                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'type' => 'in',
                    'entity' => 'Devolution',
                    'entity_id' => $devolution->id,
                    'total' => $devolution->total,
                    'date' => date('Y-m-d H:i:s')
                ]);

            }

        });

        static::updating(function($devolution)
        {

            if($devolution->status_pay == 'pagado')
            {
                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'type' => 'out',
                    'entity' => 'Devolution',
                    'entity_id' => $devolution->id,
                    'total' => $devolution->total,
                    'date' => date('Y-m-d H:i:s')
                ]);

            }

        });

        static::deleted(function($devolution)
        {
            if($devolution->status_pay == 'pagado')
            {
                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'type' => 'out',
                    'entity' => 'Devolution',
                    'entity_id' => $devolution->id,
                    'total' => $devolution->total,
                    'date' => date('Y-m-d H:i:s')
                ]);

            }
        });*/

    }

}