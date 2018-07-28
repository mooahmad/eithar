<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminHelper extends Controller
{
    /**
     * this function add and delete image
     *
     * @param $all_request
     * @param $path
     * @param $filed_name
     * @param null $old_image_path
     * @param string $cut_after_word
     * @param string $disk
     * @return mixed
     */
    public function UploadImage($all_request, $path, $filed_name, $old_image_path=null,$cut_after_word='storage',$disk='public')
    {
        //        Delete old image
        if(!empty($old_image_path)){
            $this->DeleteImage($old_image_path,$cut_after_word,$disk);
        }
        if ($all_request->hasFile($filed_name) && $all_request->file($filed_name)->isValid())
        {
            return $all_request->file($filed_name)->store($path,$disk);
        }
    }

    /**
     * @param $all_request
     * @param $path
     * @param $filed_name
     * @param null $old_image_path
     * @param string $cut_after_word
     * @param string $disk
     * @return array
     */
    public function UploadMultiImage($all_request, $path, $filed_name, $old_image_path=null,$cut_after_word='storage',$disk='public')
    {
        //        Delete old image
        if(!empty($old_image_path)){
            $this->DeleteImage($old_image_path,$cut_after_word,$disk);
        }
        $images_path=[];
        if (count($all_request->file($filed_name))){
            foreach ($all_request->file($filed_name) as $item){
                if ($item && $item->isValid())
                {
                    $images_path[] = $item->store($path,$disk);
                }
            }
        }
        return $images_path;
    }

    /**
     *  this function take image path and cut string by storage as default
     * @param $image_path
     * @param string $cut_after_word
     * @param string $disk
     * @return bool
     */
    public function DeleteImage($image_path,$cut_after_word='storage',$disk='public'){
        if(!empty($image_path)){
            $final_path = substr($image_path, strpos($image_path,$cut_after_word)+strlen($cut_after_word));
            if(Storage::disk($disk)->exists($final_path)){
                Storage::disk($disk)->delete($final_path);
                return true;
            }
        }
        return false;
    }

    /**
     * @param $view
     * @param $title
     * @param $message
     * @param $from
     * @param $from_name
     * @param $to
     * @param $to_name
     * @param null $attach
     */
    public function SendMail($view, $title, $message, $from, $from_name, $to, $to_name,$attach=null)
    {
        if(empty($from)){
            $from = env('MAIL_FROM_ADDRESS');
        }
        Mail::send($view, ['title' => $title,'msg'=>$message], function ($m) use ($from,$from_name,$to,$to_name,$title,$attach) {
            $m->from($from, $from_name);
            $m->to($to, $to_name)->subject($title);
            $m->attach($attach);
        });
    }

   public static function make_slug($string, $separator = '-')
    {
        $string = trim($string);
        $string = mb_strtolower($string, 'UTF-8');

        // Make alphanumeric (removes all other characters)
        // this makes the string safe especially when used as a part of a URL
        // this keeps latin characters and Persian characters as well
//        $string = preg_replace("/[^a-z0-9_\s-ءاآؤئبپتثجچحخدذرزژسشصضطظعغفقكگلمنوی]/u", '', $string);
        $string = preg_replace("/[^a-z0-9_\s-۰۱۲۳۴۵۶۷۸۹يةؤلأإلإأيهءاآؤئبپتثجچحخدذرزژسشصضطظعغفقکكگگلمنوهی]/u", '', $string);

        // Remove multiple dashes or whitespaces or underscores
        $string = preg_replace("/[\s-_]+/", ' ', $string);

        // Convert whitespaces and underscore to the given separator
        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;
    }
}
