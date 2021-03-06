<?php

/**
 * @copyright   2015 - 2016 Grupo MPE
 * @license     New BSD License; see LICENSE
 * @link        http://www.grupompe.com.br
 * @author      Denner Fernandes <denner.fernandes@grupompe.com.br>
 * */

namespace App\Modules\Nucleo\Controllers;

use App\Modules\Nucleo\Models\Users;
use App\Modules\Nucleo\Models\Groups;
use App\Modules\Nucleo\Models\UsersGroups;
use App\Modules\Nucleo\Models\Protheus\Colaboradores;
use App\Shared\Controllers\ControllerBase;

class UsersController extends ControllerBase
{

    /**
     * initialize
     */
    public function initialize()
    {
        $this->tag->setTitle(' Usuários ');
        parent::initialize();

        $this->entity = new Users();
    }

    /**
     * Index user
     */
    public function indexAction()
    {
        try {
            $this->view->users = Users::find();
            $this->view->pesquisa = '';
            if ($this->request->isPost()) {
                $users = $this->request->getPost('users', 'string');
                $search = "(UPPER(cpf) LIKE UPPER('%" . $users . "%') OR UPPER(email) LIKE UPPER('%" . $users . "%'))";
                $this->view->users = Users::find($search);
                $this->view->pesquisa = $users;
            }
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
        }
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->assets->collection('footerJs')->addJs('app/nucleo/users/info-user.js');
        $this->view->groups = Groups::find(['conditions' => "status = 'A'", 'order' => 'title']);
    }

    /**
     * Edits a user
     *
     * @param string $id
     */
    public function editAction($id)
    {
        try {

            if ($this->request->isPost()) {
                throw new Exception('Acesso inválido a essa action!!!');
            }

            $user = Users::findFirstByid($id);
            if (!$user) {
                throw new Exception('Usuário não encontrado!');
            }

            $this->assets->collection('footerJs')->addJs('app/nucleo/users/info-user.js');

            $this->view->id = $user->id;
            $this->view->info_user = $this->infoUserAction($user->cpf);
            $this->view->mustChangePassword = $user->getMustChangePassword();
            $this->view->groups = Groups::find(['conditions' => "status = 'A'", 'order' => 'title']);
            $this->view->usersgroups = UsersGroups::find("userId = '{$user->id}'");

            $this->tag->setDefault('id', $user->getId());
            $this->tag->setDefault('cpf', $user->getCpf());
            $this->tag->setDefault('userName', $user->getUserName());
            $this->tag->setDefault('name', $user->getName());
            $this->tag->setDefault('mustChangePassword', $user->getMustChangePassword());
            $this->tag->setDefault('email', $user->getEmail());
            $this->tag->setDefault('status', $user->getStatus());
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
            return $this->response->redirect('nucleo/users');
        }
    }

    /**
     * Creates a new user
     */
    public function createAction()
    {

        try {

            if (!$this->request->isPost()) {
                throw new Exception('Acesso não permitido a essa action.');
            }

            $user = $this->entity;

            $user->setId($user->autoincrement());
            $user->setName($this->request->getPost('name', 'string'));
            $user->setCpf($this->request->getPost('cpf', 'alphanum'));
            $user->setPassword($this->security->hash($this->request->getPost('password', 'string')));
            $user->setEmail($this->request->getPost('email', 'email'));
            $user->setUserName($this->request->getPost('userName', 'string'));
            $user->setMustChangePassword('S');
            $user->setStatus('A');

            if (!$user->create()) {
                $this->getMessageEntity($user);
            }

            foreach ($this->request->getPost('group') as $value) {
                $usersGroups = new UsersGroups();
                $usersGroups->setId($usersGroups->autoincrement());
                $usersGroups->setUserId($user->getId());
                $usersGroups->setGroupId($value);

                if (!$usersGroups->create()) {
                    $this->getMessageEntity($usersGroups);
                }
            }

            $this->flash->success('Usuário gravado com sucesso!!!');
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
        }
        return $this->response->redirect('nucleo/users');
    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction()
    {

        try {

            if (!$this->request->isPost()) {
                throw new Exception('Acesso não permitido a essa action.');
            }

            $id = $this->request->getPost('id');

            $user = Users::findFirstByid($id);
            if (!$user) {
                throw new Exception('Usuário não encontrado!');
            }

            $id = $this->request->getPost('id', 'int');

            $user->setId($id);
            $user->setName($this->request->getPost('name', 'string'));
            $user->setCpf($this->request->getPost('cpf', 'alphanum'));
            $user->setEmail($this->request->getPost('email', 'email'));
            $user->setUserName($this->request->getPost('userName', 'string'));
            $user->setStatus($this->request->getPost('status'));

            if ($this->request->getPost('mustChangePassword')) {
                $user->setMustChangePassword($this->request->getPost('mustChangePassword'));
            }

            if (!$user->update()) {
                $this->getMessageEntity($user);
            }

            $usersGroups = UsersGroups::find("userId = {$id}");

            if (!$usersGroups->delete()) {
                $this->getMessageEntity($usersGroups);
            }

            foreach ($this->request->getPost('group') as $value) {
                $usersGroups = new UsersGroups();
                $usersGroups->setId($usersGroups->autoincrement());
                $usersGroups->setUserId($user->getId());
                $usersGroups->setGroupId($value);
                if (!$usersGroups->create()) {
                    $this->getMessageEntity($usersGroups);
                }
            }

            $this->flash->success('Usuário atualizado com sucesso!!!');
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
        }
        return $this->response->redirect('nucleo/users');
    }

    /**
     * Deletes a user
     *
     * @param string $id
     */
    public function deleteAction()
    {

        try {
            if (!$this->request->isPost()) {
                throw new Exception('Acesso não permitido a essa action.');
            }

            if ($this->request->isAjax()) {
                $this->view->disable();
            }

            $id = $this->request->getPost('id');

            $user = Users::findFirstByid($id);
            if (!$user) {
                throw new Exception('Usuário não encontrado!');
            }

            if (!$user->delete()) {
                $this->getMessageEntity($user);
            }
            echo 'ok';
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
            return $this->response->redirect('nucleo/users');
        }
    }

    public function profileAction()
    {

    }

    public function infoUserAction($cpf = null)
    {
        try {

            if ($this->request->isPost()) {
                $this->view->disable();
                $cpf = $this->request->getPost('cpf', 'alphanum');
                $colaborador = new Colaboradores();
                echo json_encode($colaborador->getDadosFuncionario($cpf));
                return true;
            }
            $colaborador = new Colaboradores();
            return $colaborador->getDadosFuncionario($cpf);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function infoUserAjaxAction()
    {
        try {

            if (!$this->request->isAjax()) {
                throw new Exception('Acesso não permitido a essa action.');
            }

            $this->view->disable();
            $aux = explode('@', $this->request->getPost('search'));
            if (isset($aux[1])) {
                $search = $this->request->getPost('search', 'email');
            } else {
                $search = $this->request->getPost('search', 'alphanum');
            }
            $all = $this->request->getPost('all');

            if (empty($search)) {
                return false;
            }

            $colaborador = new Colaboradores();

            if (is_null($all)) {
                $return = $colaborador->getColaboradorByCpf($search);
            } else {
                if (!isset($aux[1])) {
                    $return = $colaborador->getColaborador($search);
                } else {
                    $return = $colaborador->getColaboradorByEmail($search);
                }
            }

            if (is_null($return)) {
                echo 'Não encontrado';
                return false;
            } else {
                echo json_encode($return);
                return true;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}
