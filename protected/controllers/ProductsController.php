<?php
class ProductsController extends Controller
{

    public $default_item_tpl = "item";
    public $default_list_tpl = "list";

    /**
     * Main entry point (default action) - show all items in catalog and also show sub-categories
     * @param $id
     * @param int $page
     * @throws CHttpException
     */
    public function actionShow($id,$page = 1)
    {
        //current category
        $objProdCatalogCategory = ExtProductCategory::model()->findByPk($id);

        //if not found
        if(empty($objProdCatalogCategory))
        {
            throw new CHttpException(404);
        }

        //current category
        $arrCategory = $this->objToAssoc($objProdCatalogCategory,true);

        //all active(visible) sub-categories
        $arrSubCats = ExtProductCategory::model()->buildMenuItemsArrayFromObjArr($id,true);
        foreach($arrSubCats as $index => $subCat)
        {
            $arrSubCats[$index]['link'] = Yii::app()->createUrl('products/show/',array('id' => $subCat['id']));
        }

        //bread-crumbs
        $breadcrumbs = $objProdCatalogCategory->breadCrumbs(true,true);
        $arrBreadCrumbs = array();
        foreach($breadcrumbs as $id => $breadcrumb)
        {
            $arrBreadCrumbs[] = array('link' => Yii::app()->createUrl('products/show/',array('id' => $id)),'name' => $breadcrumb);
        }

        //all active(visible) items
        $items = $objProdCatalogCategory->allRelatedItems(true,true);
        $objItems = CPaginator::getInstance($items,10,$page)->getPreparedArray(true);
        $arrItems = $this->objArrToAssoc($objItems,true);

        //pagination links
        $pagination = array();
        for($i=0; $i < CPaginator::getInstance()->getTotalPages(); $i++)
        {
            $pagination[$i+1] = Yii::app()->createUrl('products/show/',array('id' => $id, 'page' => $i+1));
        }


        //default template
        $template = $this->default_list_tpl;

        //if category has template name
        if(!empty($objProdCatalogCategory->template_name))
        {
            //remove php extension
            $temp = $objProdCatalogCategory->template_name;
            $temp = str_replace(".php","",$temp);

            //if file exist
            if($this->getViewFile('category/'.$temp))
            {
                //set this template
                $template = $temp;
            }
        }

        $this->title = $objProdCatalogCategory->trl->header;
        $this->keywords = $objProdCatalogCategory->trl->meta_description;
        $this->description = $objProdCatalogCategory->trl->description;

        //render list
        $this->render('category/'.$template,array(
            'products' => $arrItems,
            'subcategories' => $arrSubCats,
            'breadcrumbs' => $arrBreadCrumbs,
            'category' => $arrCategory,
            'page' => $page,
            'pagination' => $pagination
        ));
    }

    public function actionOne($id)
    {
        Debug::out($id);
        exit('Under construction...');
    }




    /****************************************** H E L P E R - M E T H O D S *******************************************/


    /**
     * Converts object array to associative array
     * @param $objArr
     * @param bool $trl
     * @return array
     */
    public function objArrToAssoc($objArr,$trl = false)
    {
        /* @var $objArr CActiveRecord[] | ExtProduct[] | ExtNews[] | ExtProductCategory[] | ExtNewsCategory[] */

        $result = array();

        foreach($objArr as $index => $obj)
        {
            $attributes = $obj->attributes;
            $result[] = $attributes;

            if(isset($obj->imagesOfProducts))
            {
                /* @var $first_img ExtImages */
                $first_img = $obj->getFirstImage();
                if(!empty($first_img))
                {
                    $result[$index]['first_image'] = $first_img->attributes;
                }
            }

            if($trl && isset($obj->trl))
            {
                $result[$index]['trl'] = $obj->trl->attributes;
            }
        }

        return $result;
    }

    /**
     * Converts single object to associative array
     * @param CActiveRecord | ExtProduct | ExtNews | ExtProductCategory | ExtNewsCategory $obj
     * @param bool $trl
     * @return mixed
     */
    public function objToAssoc($obj,$trl = false)
    {
        $attributes = $obj->attributes;

        if($trl && isset($obj->trl))
        {
            $attributes['trl'] = $obj->trl->attributes;
        }

        return $attributes;
    }

}