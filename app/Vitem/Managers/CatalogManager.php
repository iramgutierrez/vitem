<?php namespace Vitem\Managers;

use Vitem\Validators\CatalogValidator;


class CatalogManager extends BaseManager {

    protected $catalog;

    
    public function save()
    {
        $CatalogValidator = new CatalogValidator(new \Catalog);

        $catalogData = $this->data; 

        $catalogData = $this->prepareData($catalogData);

        $catalogValid  =  $CatalogValidator->isValid($catalogData);

        if( $catalogValid )
        {

            if(!empty($catalogData['id']))
            {
                $catalog = \Catalog::find($catalogData['id']);

                if($catalog)
                {
                    unset($catalogData['id']);

                    $catalog->update($catalogData);
                }

            }
            else
            {
                $catalog = new \Catalog( $catalogData ); 
            
                $catalog->save(); 

            }
            
            

            $response = [
                'success' => true,
                'return_id' => $catalog->id,
                'catalog' => $catalog
            ];            

        }
        else
        {
            
            $catalogErrors = [];

            if($CatalogValidator->getErrors())
                $catalogErrors = $CatalogValidator->getErrors()->toArray();            

            $errors =  $catalogErrors;

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

    public function prepareData($catalogData)
    {
        
        $catalogData['user_id'] = \Auth::user()->id;

        $catalogData['slug'] = \Str::slug($catalogData['name']);

        return $catalogData;
    }

} 

