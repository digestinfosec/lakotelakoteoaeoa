<?php

use Intervention\Image\ImageManagerStatic as Image;

class Image_model extends MY_Model
{
    // Get all images from a class
    public function get_images_from_class($class_id)
    {
        $this->db->where('entity_id', $class_id);
        $query = $this->db->get('images');

        return $query->result();
    }

    // Save the image (files) to server with an aspect ratio and size of
    // big, small, and thumb
    public function save_image_to_server()
    {
        Image::configure();

        $this->load->helper('string');
        $image_name = random_string('alnum', 16) . time();
        $image = Image::make($_FILES['file_data']['tmp_name']);
        $image_big = Image::make($_FILES['file_data']['tmp_name']);
        $image_small = Image::make($_FILES['file_data']['tmp_name']);
        $image_thumb = Image::make($_FILES['file_data']['tmp_name']);
        $extension = image_type_to_extension(exif_imagetype($_FILES['file_data']['tmp_name']));
        $extension = $extension == '.jpeg' ? '.jpg' : $extension;

        // Set the width of the area and height of the area
        $width_big = 700;
        $height_big = 400;

        // Get the width and height of the Image
        $width = $image->width();
        $height = $image->height();

        // So then if the image is wider rather than taller, set the width and figure out the height
        if (($width/$height) > ($width_big/$height_big)) {
            $outputwidth = $width_big;
            $outputheight = ($width_big * $height)/ $width;
        }
        // And if the image is taller rather than wider, then set the height and figure out the width
        elseif (($width/$height) < ($width_big/$height_big)) {
            $outputwidth = ($height_big * $width)/ $height;
            $outputheight = $height_big;
        }
        // And because it is entirely possible that the image could be the exact same size/aspect ratio of the desired area, so we have that covered as well
        elseif (($width/$height) == ($width_big/$height_big)) {
            $outputwidth = $width_big;
            $outputheight = $height_big;
        }

        $image_big->resize(700, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image_big->save(FCPATH . '/images/class/' . $image_name . $extension);

        // Set the width of the area and height of the area
        $width_small = 350;
        $height_small = 200;

        // Get the width and height of the Image
        $width = $image->width();
        $height = $image->height();

        // So then if the image is wider rather than taller, set the width and figure out the height
        if (($width/$height) > ($width_small/$height_small)) {
            $outputwidth = $width_small;
            $outputheight = ($width_small * $height)/ $width;
        }
        // And if the image is taller rather than wider, then set the height and figure out the width
        elseif (($width/$height) < ($width_small/$height_small)) {
            $outputwidth = ($height_small * $width)/ $height;
            $outputheight = $height_small;
        }
        // And because it is entirely possible that the image could be the exact same size/aspect ratio of the desired area, so we have that covered as well
        elseif (($width/$height) == ($width_small/$height_small)) {
            $outputwidth = $width_small;
            $outputheight = $height_small;
        }

        $image_small->resize(350, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image_small->save(FCPATH . '/images/class/' . $image_name . '_small' . $extension);

        // Set the width of the area and height of the area
        $width_thumb = 160;
        $height_thumb = 160;

        // Get the width and height of the Image
        $width = $image->width();
        $height = $image->height();

        // So then if the image is wider rather than taller, set the width and figure out the height
        if (($width/$height) > ($width_thumb/$height_thumb)) {
            $outputwidth = $width_thumb;
            $outputheight = ($width_thumb * $height)/ $width;
        }
        // And if the image is taller rather than wider, then set the height and figure out the width
        elseif (($width/$height) < ($width_thumb/$height_thumb)) {
            $outputwidth = ($height_thumb * $width)/ $height;
            $outputheight = $height_thumb;
        }
        // And because it is entirely possible that the image could be the exact same size/aspect ratio of the desired area, so we have that covered as well
        elseif (($width/$height) == ($width_thumb/$height_thumb)) {
            $outputwidth = $width_thumb;
            $outputheight = $height_thumb;
        }

        $image_thumb->fit(160, 160);
        $image_thumb->save(FCPATH . '/images/class/' . $image_name . '_thumb' . $extension);

        $create = $this->session->userdata('create_update_class') ? $this->session->userdata('create_update_class') : [];
        $create['image'][] = ['name' => $image_name . $extension];

        $this->session->set_userdata('create_update_class', $create);
        echo json_encode(['filename' => $image_name . $extension, 
                            'initialPreview' => [
                                "<img style='height:160px;width:auto' src='" . base_url("images/class/". $image_name . $extension) . "'>" 
                            ],
                            'initialPreviewConfig' => [
                            ['url' => base_url('/dashboard/teacher/course/delete-image-from-cache/'. $image_name) , 'key' => 1],
                            ],
                            'append' => true // whether to append these configurations to initialPreview.
                                             // if set to false it will overwrite initial preview
                                             // if set to true it will append to initial preview
            ]);
    }

    // Save the image location of a class to database
    public function save_image_for_class($class_id)
    {
        if ($this->session->userdata('create_update_class'))
            $create = $this->session->userdata('create_update_class');
        else
            return;

        // First remove the images first
        $this->remove_images_for_class($class_id);

        $images = $create['image'];

        foreach($images as $image) {
            $this->db->insert('images', [
                'entity' => 'classes',
                'entity_id' => $class_id,
                'path' => 'images/class/',
                'title' => $image['name']
            ]);
        }
    }

    // Remove the image (files) from server
    public function remove_image_from_server($image_id)
    {
        $this->db->where('id', $image_id);
        $query = $this->db->get('images')->row();
        $image_file = $query->path . $query->title;

        unlink($image_file);
        unlink(substr($image_file, 0, -4) . "_small" . substr($image_file, -4));
        unlink(substr($image_file, 0, -4) . "_thumb" . substr($image_file, -4));
        $this->remove_image($image_id);
    }

    // Remove the images for a class from database
    public function remove_images_for_class($class_id)
    {
        $this->db->where('entity_id', $class_id);
        $query = $this->db->get('images');

        foreach($query->result() as $image) {
            if (!$this->remove_image($image->id)) {
                return false;
            }
        }

        return true;
    }

    // Remove the image from database with ID
    public function remove_image($image_id)
    {
        $this->db->where('id', $image_id);
        return $this->db->delete('images');
    }


}
