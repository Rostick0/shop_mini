<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductPropertyItem\StoreProductPropertyItemRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Casts\Json;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Utils\QueryString;
use Illuminate\Http\Request;
use Validator;

class ProductController extends ApiController
{
    public function __construct()
    {
        $this->model = new Product;
        $this->is_auth_id = true;
        $this->store_request = new StoreProductRequest;
        $this->update_request = new UpdateProductRequest;
    }

    protected static function extendsMutation($data, $request)
    {
        $data->images()->delete();
        if ($request->has('images')) {
            $images = array_map(function ($image_id) {
                return ['image_id' => $image_id];
            }, QueryString::convertToArray($request->images));

            $data->images()->createMany($images);
        }

        $data->files()->delete();
        if ($request->has('files')) {
            $files = array_map(function ($file_id) {
                return ['file_id' => $file_id];
            }, QueryString::convertToArray($request->files));

            $data->files()->createMany($files);
        }

        // $data->product_property_item()->delete();
        // if ($request->has('product_property_item')) {
        //     $product_property_items = [];

        //     foreach (Json::decode($request->product_property_item) as $item) {
        //         $valid = Validator::make($item, (new StoreProductPropertyItemRequest)->rules());

        //         if (!$valid->passes()) continue;

        //         $product_property_items[] = $valid->validated();
        //     }  

        //     $data->product_property_items()->createMany($product_property_items);
        // }
    }

    /**
     * Index
     * @OA\Get (
     *     path="/api/products",
     *     tags={"Products"},
     *     security={{"bearer_token": {}}},
     *     @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          @OA\Schema(
     *              type="object",
     *              example={
     *                 "filter[id]":null,
     *                 "filter[title]":null,
     *                 "filter[description]":null,
     *                 "filter[price]":null,
     *                 "filter[old_price]":null,
     *                 "filter[count]":null,
     *                 "filter[is_infinitely]":null,
     *                 "filter[raiting]":null,
     *                 "filter[user_id]":null,
     *                 "filter[category_id]":null,
     *                 "filter[created_at]":null,
     *                 "filter[updated_at]":null,
     *               }
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="sort",
     *          in="query",
     *          example="id",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          example="1",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          example="20",
     *          @OA\Schema(
     *              type="number",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="extends",
     *          in="query",
     *          example="parent,children",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object",
     *                  ref="#/components/schemas/ProductSchema"
     *              ),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        return parent::index($request);
    }

    /**
     * Store
     * @OA\Post (
     *     path="/api/products",
     *     tags={"Products"},
     *     security={{"bearer_token": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"title", "price", "category_id"},
     *                  @OA\Property(
     *                      property="data",
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),                 
     *                      @OA\Property(
     *                          property="price",
     *                          type="float"
     *                      ),
     *                      @OA\Property(
     *                          property="old_price",
     *                          type="float"
     *                      ),
     *                      @OA\Property(
     *                          property="count",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="is_infinitely",
     *                          type="boolean"
     *                      ),
     *                      @OA\Property(
     *                          property="category_id",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="images",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "title":"Кухонные приборы",
     *                     "description":"Описание",
     *                     "price": "100.00",
     *                     "old_price": "90.00",
     *                     "count": "30",
     *                     "is_infinitely": "false",
     *                     "category_id": "1",
     *                     "images": "1,2,3"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object",
     *                  ref="#/components/schemas/ProductSchema"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Validation error",
     *          @OA\JsonContent(
     *                  @OA\Property(property="message", type="string", example="The title field is required. (and 1 more errors)"),
     *                  @OA\Property(property="errors", type="object",
     *                      @OA\Property(property="title", type="array", collectionFormat="multi",
     *                        @OA\Items(
     *                          type="string",
     *                          example="The title field is required.",
     *                          )
     *                      ),
     *                  ),
     *          )
     *      )
     * )
     */

    public function store(Request $request)
    {
        return parent::store($request);
    }

    /**
     * Show
     * @OA\Get (
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *      @OA\Parameter( 
     *          name="id",
     *          in="path",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *              type="number"
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="extends",
     *          in="query",
     *          example="images,user,category",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object",
     *                  ref="#/components/schemas/ProductSchema"
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Validation error",
     *          @OA\JsonContent(
     *                  @OA\Property(property="message", type="string", example="Not found"),
     *                  ),
     *          )
     *      )
     * )
     */
    public function show(Request $request, int $id)
    {
        return parent::show($request, $id);
    }

    /**
     * Update
     * @OA\Patch (
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     security={{"bearer_token": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"title", "price", "category_id"},
     *                  @OA\Property(
     *                      property="data",
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),                 
     *                      @OA\Property(
     *                          property="price",
     *                          type="float"
     *                      ),
     *                      @OA\Property(
     *                          property="old_price",
     *                          type="float"
     *                      ),
     *                      @OA\Property(
     *                          property="count",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="is_infinitely",
     *                          type="boolean"
     *                      ),
     *                      @OA\Property(
     *                          property="category_id",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="images",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "title":"Кухонные приборы",
     *                     "description":"Описание",
     *                     "price": "100.00",
     *                     "old_price": "90.00",
     *                     "count": "30",
     *                     "is_infinitely": "false",
     *                     "category_id": "1",
     *                     "images": "1,2,3"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object",
     *                  ref="#/components/schemas/ProductSchema"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Validation error",
     *          @OA\JsonContent(
     *                  @OA\Property(property="message", type="string", example="The title field is required. (and 1 more errors)"),
     *                  @OA\Property(property="errors", type="object",
     *                      @OA\Property(property="title", type="array", collectionFormat="multi",
     *                        @OA\Items(
     *                          type="string",
     *                          example="The title field is required.",
     *                          )
     *                      ),
     *                  ),
     *          )
     *      )
     * )
     */
    public function update(Request $request, int $id)
    {
        return parent::update($request, $id);
    }

    /**
     * Delete
     * @OA\Delete (
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     security={{"bearer_token": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Deleted"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Access error",
     *          @OA\JsonContent(
     *                  @OA\Property(property="message", type="string", example="No access"),
     *                 ),
     *          )
     *      )
     * )
     */
    public function destroy(int $id)
    {
        return parent::destroy($id);
    }
}
