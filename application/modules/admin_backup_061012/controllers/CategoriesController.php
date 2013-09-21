<?php
/**
 * Category Controller
 *
 * @category    Controller
 * @package     Admin
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class Admin_CategoriesController extends Speed_Controller_ActionController
{
    protected $blogModel;

    protected function initialize()
    {
        $this->view->navBar = 'category';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $categoryDisplayModel = new Admin_Model_BlogCategory();
        $display = $categoryDisplayModel->getAll();
        $this->view->display = $display;

    }

    public function editAction()
    {
        $this->validateAdmin();
        $blogCategoryModel = new Admin_Model_BlogCategory();
        $categoryId = $this->_request->getParam('id');
        $blogCategoryModel->getDetail($categoryId);
        $categoryEntry = new Admin_Form_CategoryEntry(array(
            'isEdit' => true,
            'category_name' => $categoryId
        ));

        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($categoryEntry->isValid($data)) {
                $result = $blogCategoryModel->modify($data, $categoryId);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/categories/index','Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/categories/index','Category has updated successfully.');
                }
            } else {
                $categoryEntry->populate($data);
            }
        } else {

            if (empty($categoryId)) {
                $this->redirectForFailure('/admin/categories/index','No Category found');
            } else {
                $categoryModel = new Admin_Model_BlogCategory();
                $categoryData = $categoryModel->getDetail($categoryId);
                if (empty($categoryData)) {
                    $this->redirectForFailure('/admin/categories/index','No Category found.');
                } else {
                    $categoryEntry->populate($categoryData);
                }
            }
        }
        $this->view->CategoryEntry = $categoryEntry;

    }


    public function deleteAction()
    {
        $this->validateAdmin();
        $categoryDeleteModel = new Admin_Model_BlogCategory();

        $categoryId = $this->_request->getParam('id');

        $status = $categoryDeleteModel->delete($categoryId);

        if ($status) {
            $this->redirectForSuccess("/admin/categories", "Category deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/categories/", "Something went wrong. Please try again");
        }
    }

    public function addAction()
    {
        $this->validateAdmin();

        $categoryEntry = new Admin_Form_CategoryEntry();

        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();
            $data['category_name'] = stripslashes($this->_request->getParam('category_name'));


            if ($categoryEntry->isValid($data)) {

                $categoryModel = new Admin_Model_BlogCategory();

                $result = $categoryModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/categories/index','There was a problem , Please try again.');
                } else {

                    $this->redirectForSuccess('/admin/categories/index','Category Posted sucessfully');
                }

            } else {
                $categoryEntry->populate($data);
            }
        }

        $this->view->CategoryEntry = $categoryEntry;

    }
	public function showSubcategoryAction()
    {
        $this->validateAdmin();
        $subcategoryModel = new Admin_Model_SubCategory();
        $display = $subcategoryModel->getAll();
        $this->view->display = $display;

    }
    
    public function addsubcategoryAction()
    {
        $this->validateAdmin();
        $categoryModel = new Admin_Model_BlogCategory();     
        $subcategoryEntry = new Admin_Form_SubcategoryEntry(array(     
            'blog_category_id' => $categoryModel->getAll(),    
            'isEdit' => false
        ));

        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();
            $data['category_name'] = stripslashes($this->_request->getParam('category_name'));       


            if ($subcategoryEntry->isValid($data)) {          

                $subcategoryModel = new Admin_Model_SubCategory();       

                $result = $subcategoryModel->save($data);         
                if (empty($result)) {
                    $this->redirectForFailure('/admin/categories/show-subcategory','There was a problem , Please try again.');
                } else {

                    $this->redirectForSuccess('/admin/categories/show-subcategory','Sub category inserted sucessfully');
                }									

            } else {
                $subcategoryEntry->populate($data);          	
            }
        }

        $this->view->SubcategoryEntry = $subcategoryEntry;	

    }
    
    public function editSubcategoryAction()
    {
        $this->validateAdmin();
       // $this->_helper->layout->setLayout('admin');
        $subcategoryModel = new Admin_Model_SubCategory();        
        $subcategoryId = $this->_request->getParam('id');         
        $subcategoryModel->getDetail($subcategoryId);           
        $categoryModel = new Admin_Model_BlogCategory();     
        $subcategoryEntry = new Admin_Form_SubcategoryEntry(array(        
            'blog_category_id' => $categoryModel->getAll(),      
            'isEdit' => true,
            'subcategory_id' => $subcategoryId             
        ));

        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($subcategoryEntry->isValid($data)) {             
                $result = $subcategoryModel->modify($data, $data['subcategory_id']);     
                if (empty($result)) {
                    $this->redirectForFailure('/admin/categories/show-subcategory','Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/categories/show-subcategory','Sub category has been updated successfully.');
                }
            } else {
                $subcategoryEntry->populate($data);       
            }
        } else {

            if (empty($subcategoryId)) {      
                $this->redirectForFailure('/admin/categories/show-subcategory','No Sub category found');
            } else {
                $subcategoryModel = new Admin_Model_SubCategory();       
                $subcategoryData = $subcategoryModel->getDetail($subcategoryId);       
                if (empty($subcategoryData)) {                           
                    $this->redirectForFailure('/admin/categories/show-subcategory','No Sub category found.');
                } else {
                    $subcategoryEntry->populate($subcategoryData);       
                }
            }
        }
        $this->view->SubcategoryEntry = $subcategoryEntry;	

    }
    
    public function deleteSubcategoryAction()
    {
        $this->validateAdmin();
        $subcategoryModel = new Admin_Model_SubCategory();      

        $subcategoryId = $this->_request->getParam('id');    

        $status = $subcategoryModel->delete($subcategoryId);          

        if ($status) {
            $this->redirectForSuccess("/admin/categories/show-subcategory", "Sub Category deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/categories/show-subcategory", "Something went wrong. Please try again");
        }
    }
}
