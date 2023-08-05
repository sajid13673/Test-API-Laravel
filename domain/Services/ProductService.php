<?php
namespace domain\Services;

use App\Models\Image;
use App\Models\Product;
use App\Helper\ImageManager;


class ProductService{
    use ImageManager;

    protected $product;
    protected $image;

    public function __construct()
    {
        $this->product = new Product();
        $this->image = new Image();
    }
    public function all(){
        return $this->product->with(['image' => function ($query) {
            return $query->select(['image_name', 'product_id']);
        }])->get();
    }
    public function store($data){
        $item = $this->product->create($data->all());
        if ($file = $data->file('image')) {
            $fileData = $this->uploads($file);
            $this->image->create(['image_name' => $fileData['fileName'], 'product_id' => $item->id]);
        }
    }
    public function get($id){
        return $this->product->with('image')->find($id);
    }
    public function update($data, $id){
        $item = $this->product->find($id);
        $item->update($data->toArray());
        if ($file = $data->file('image')) {
            $fileData = $this->uploads($file);
            if ($item->image === null) {
                $this->image->create(['image_name' => $fileData['fileName'], 'product_id' => $item->id]);
            } else {
                $this->deleteImage($item->image->image_name);
                $item->image->update(['image_name' => $fileData['fileName'], 'product_id' => $item->id]);
            }
        }
    }
    public function delete($id){
        $item = $this->product->find($id);
        if ($item->image !== null) {
            $this->deleteImage($item->image->image_name);
            $item->image->delete();
        }
        $item->delete();
        return $item;
    }
}
