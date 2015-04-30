<?php
/**
 * Class NewsForm
 */
class MediaUploadFormValidation extends CFormModel
{
    public $image;
    public $video;
    public $archive;
    public $audio;
    public $pdf;
    public $flash;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('image', 'file', 'types'=>'jpg, gif, png','allowEmpty' =>true,'maxSize' => 1048576),
            array('video', 'file', 'types'=>'avi, wmv, mp4','allowEmpty' =>true,'maxSize' => 9000000),
            array('archive', 'file', 'types'=>'zip, rar, tar','allowEmpty' => true, 'maxSize' => 9000000),
            array('audio', 'file', 'types'=>'wav, mp3','allowEmpty' =>true,'maxSize' => 7000000),
            array('pdf', 'file', 'types'=>'pdf','allowEmpty' =>true,'maxSize' => 9000000),
            array('flash', 'file', 'types'=>'swf','allowEmpty' =>true,'maxSize' => 9000000),
        );
    }
}