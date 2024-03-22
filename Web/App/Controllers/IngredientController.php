<?php 
namespace App\Controllers;
use App\Operations\IngredientReadOperation;
use App\Operations\IngredientCreateOperation;
use App\Operations\IngredientUpdateOperation;
use App\Operations\ValidateIngredientDataHolder;

class IngredientController extends BaseController
{
    public function index() {
        return $this->loadView('ingredient.list_all');
    }
    public function listByCategory() {
        $category = $_GET['category'];
        $ingredients = IngredientReadOperation::getAllObjectsByFieldAndValue('category', $category);
        if(! $ingredients == null) 
            return $this->loadView('ingredient.list_all', $ingredients);
        else
            echo \App\Views\ViewRender::errorViewRender('410');
    }
    public function listByCategoryWithOffset() {
        $category = $_GET['category'];
        $offset = $_GET['offset'];
        $limit = $_GET['limit'];
        $ingredients = IngredientReadOperation::getObjectWithOffsetByFielAndValue('category', $category, $offset, $limit);
        if ($ingredients == null) {
            echo \App\Views\ViewRender::errorViewRender('410');
        }
        else
            return $this->loadView('ingredient.list_all', $ingredients);
    }
    public function addUI() {
        $optionVal = ValidateIngredientDataHolder::getInstance();
        $data[] = $optionVal;
        return $this->loadView('ingredient.add', $data);
    }
    public function add() {
        $data = $_POST;

        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();

        IngredientCreateOperation::execute($data);
        header("Location: /ingredient/add");
    }
    public function findByName(){
        return $this->loadView('ingredient.find_ingredient');
    }
    public function editUI() {
        try {
            $ingredient = IngredientReadOperation::getSingleObjectById(1);
            $data[] = $ingredient; 
            return $this->loadView('ingredient.update', $data);
        } catch (\PDOException $PDOException) {
            handlePDOException($PDOException);
            echo \App\Views\ViewRender::errorViewRender('500');
        } catch (\Exception $exception) {
            handleException($exception);
        } catch (\Throwable $throwable) {
            handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
        }
        echo \App\Views\ViewRender::errorViewRender('404');
        return null;
    }
    public function edit() {
        $data = $_POST;
        IngredientUpdateOperation::execute($data);
        header("Location: /ingredient/edit");
    }

    public function test() {
        $ingredients = IngredientReadOperation::getAllObjects();
        echo '<pre>';
        var_dump($ingredients);
        echo '</pre>';

        $this->loadView('pages.test', $ingredients);

    }

}