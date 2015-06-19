<?php namespace Vitem\Managers;

use Vitem\Validators\ColorValidator;


class ColorManager extends BaseManager {

    protected $color;

    
    public function save()
    {
        $ColorValidator = new ColorValidator(new \Color);

        $colorData = $this->data; 

        $colorData = $this->prepareData($colorData);

        $colorValid  =  $ColorValidator->isValid($colorData);

        if( $colorValid )
        {

            if(!empty($colorData['id']))
            {
                $color = \Color::find($colorData['id']);

                if($color)
                {
                    unset($colorData['id']);

                    $color->update($colorData);
                }

            }
            else
            {
                $color = new \Color( $colorData ); 
            
                $color->save(); 

            }
            
            

            $response = [
                'success' => true,
                'return_id' => $color->id,
                'color' => $color
            ];            

        }
        else
        {
            
            $colorErrors = [];

            if($ColorValidator->getErrors())
                $colorErrors = $ColorValidator->getErrors()->toArray();            

            $errors =  $colorErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {
    }

    public function delete()
    {

        

    }

    public function prepareData($colorData)
    {
        
        $colorData['user_id'] = \Auth::user()->id;

        $colorData['slug'] = \Str::slug($colorData['name']);

        return $colorData;
    }

} 

