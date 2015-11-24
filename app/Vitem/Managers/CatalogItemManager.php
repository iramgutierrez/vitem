<?php namespace Vitem\Managers;

use Vitem\Validators\CatalogItemValidator;


class CatalogItemManager extends BaseManager {

    protected $catalogItem;

    
    public function save()
    {
        $CatalogItemValidator = new CatalogItemValidator(new \CatalogItem);

        $catalogItemData = $this->data; 

        $catalogItemData = $this->prepareData($catalogItemData);

        $catalogItemValid  =  $CatalogItemValidator->isValid($catalogItemData);

        if( $catalogItemValid )
        {

            $catalogItem = new \CatalogItem( $catalogItemData );

            $catalogItem->save();

            $response = [
                'success' => true,
                'return_id' => $catalogItem->id,
                'catalogItem' => $catalogItem
            ];            

        }
        else
        {
            
            $catalogItemErrors = [];

            if($CatalogItemValidator->getErrors())
                $catalogItemErrors = $CatalogItemValidator->getErrors()->toArray();            

            $errors =  $catalogItemErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {
        $catalogItemData = $this->data;

        $this->catalogItem = \CatalogItem::find($catalogItemData['id']);

        $CatalogItemValidator = new CatalogItemValidator($this->catalogItem);

        $catalogItemData = $this->prepareData($catalogItemData);

        $catalogItemValid  =  $CatalogItemValidator->isValid($catalogItemData);

        if( $catalogItemValid )
        {
            $catalogItem = $this->catalogItem;

            $catalogItem->update($catalogItemData);

            $response = [
                'success' => true,
                'return_id' => $catalogItem->id,
                'catalogItem' => $catalogItem
            ];

        }
        else
        {

            $catalogItemErrors = [];

            if($CatalogItemValidator->getErrors())
                $catalogItemErrors = $CatalogItemValidator->getErrors()->toArray();

            $errors =  $catalogItemErrors;

            $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;
    }

    public function delete()
    {

        $catalogItemData = $this->data;

        $this->catalogItem = \CatalogItem::find($catalogItemData['id']);

        $catalogItem = $this->catalogItem;

        $catalogItem->delete();

        return [
            'success' => true
        ];

    }

    public function prepareData($catalogItemData)
    {
        
        $catalogItemData['user_id'] = \Auth::user()->id;

        $catalogItemData['slug'] = \Str::slug($catalogItemData['name']);

        return $catalogItemData;
    }

} 

