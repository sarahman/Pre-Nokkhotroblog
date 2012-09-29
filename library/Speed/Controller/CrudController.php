<?php

/**
 * Speed Crud Controller
 *
 * @category    Controller
 * @author      Syed Abidur Rahman <abid@rightbrainsolution.com>
 * @copyright   Right Brain Solution Ltd. <http://rightbrainsolution.com>
 */
class Speed_Controller_CrudController extends Speed_Controller_ActionController
{
    /**
     * Validate and insert user data into a table of a database
     * and redirect to another page with setting message.
     *
     * The following option keys are supported:
     * 'form'           => The form to validate against
     * 'model'          => The model corresponding to the table to be inserted into
     * 'dataToBeAdded'  => The data which is to be included into the post data
     * 'redirectLink'   => The link where to redirect
     * 'message'        => The message to be set while redirecting
     *
     * @param array $data Options to use for this function
     * @return void
     */
    protected function create(array $data)
    {
        $form = $data['form'];
        $model = $data['model'];
        $dataToBeAdded = empty ($data['dataToBeAdded']) ? array() : $data['dataToBeAdded'];
        $redirectLink = $data['redirectLink'];
        $message = empty($data['message']) ? 'Data has been successfully added.' : $data['message'];

        if ($this->_request->isPost()) {

            $postData = $this->_request->getPost();

            if ($form->isValid($postData)) {

                $postData = array_merge($postData, $dataToBeAdded);
                $model->save($postData);

                $this->redirectForSuccess($redirectLink, $message);

            } else {
                $form->populate($postData);
            }
        }
    }

    /**
     * Validate and update user data into a table of a database
     * corresponding to a value of the primary key of that table
     * and redirect to another page with setting message.
     *
     * The following option keys are supported:
     * 'form'           => The form to validate against
     * 'model'          => The model corresponding to a table to be updated
     * 'dataToBeAdded'  => The data which is to be included into the post data
     * 'id'             => The value of the primary key of the table
     * 'redirectLink'   => The link where to redirect
     * 'message'        => The message to be set while redirecting
     *
     * @param array $data Options to use for this function
     * @return void
     */
    protected function update(array $data)
    {
        $form = $data['form'];
        $model = $data['model'];
        $id = $data['id'];
        $dataToBeAdded = empty ($data['dataToBeAdded']) ? array() : $data['dataToBeAdded'];
        $redirectLink = $data['redirectLink'];
        $message = empty($data['message']) ? 'Data has been successfully updated.' : $data['message'];

        if ($this->_request->isPost()) {

            $postData = $this->_request->getPost();

            if ($form->isValid($postData)) {

                $postData = array_merge($postData, $dataToBeAdded);
                $model->update($postData, $id);

                $this->redirectForSuccess($redirectLink, $message);

            } else {
                $form->populate($postData);
            }
        } elseif (empty($id)) {

            $this->redirectForFailure($redirectLink, 'Data has not been found.');

        } else {

            $detailData = $model->getDetail($id);
            if (empty($detailData)) {
                $this->redirectForFailure($redirectLink, 'Data has not been found.');
            } else {
                $form->populate($detailData);
            }
        }
    }

    /**
     * Remove user data from a table corresponding to its primary key
     * and confirm the data is deleted or not.
     *
     * The following option keys are supported:
     * 'model'          => The model corresponding to the table to be deleted from
     * 'redirectLink'   => The link where to redirect
     * 'message'        => The message to be set while redirecting
     *
     * @param string $id
     * @param Speed_Model_Abstract $model
     * @return void
     */
    protected function delete($id, Speed_Model_Abstract $model)
    {
        $this->disableRendering();

        $result = $model->delete($id);
        echo Zend_Json::encode(array('status' => $result));
    }

    protected function validateUser()
    {
        $authNamespace = new Zend_Session_Namespace('userInformation');

        if (empty($authNamespace->userData['username'])){
            $this->_redirect('/user/auth/login');
        }
    }
}