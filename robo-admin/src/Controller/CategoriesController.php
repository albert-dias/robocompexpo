<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $name       = isset($this->request->data['name']) ? $this->request->data['name'] : NULL;
        $id         = isset($this->request->data['id']) ? $this->request->data['id'] : NULL;
        $active     = isset($this->request->data['active']) ? $this->request->data['active'] : NULL;
        $conditions = [];
        
        $conditions['Categories.company_id'] = $this->request->session()->read('Auth.User.company_id');

        if ($id) {
            $conditions['Categories.id'] = $id;
        }

        if ($name) {
            $conditions['Categories.name LIKE '] = "%$name%";
        }
        
        if (isset($active) && $active != '') {
            $conditions['Categories.active'] = $active;
        }
        
        $this->paginate = [
            'conditions' => $conditions,
            'contain' => 'Subcategories'
        ];
        
        $categories = $this->paginate($this->Categories);

        $this->set(compact('categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Companies', 'Subcategories']
        ]);

        $this->set('category', $category);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['company_id'] = $this->request->session()->read('Auth.User.company_id');
            $this->request->data['active'] = true;
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('Categoria salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A categoria não pode ser salva. Por favor, tente novamente.'));
        }
        $companies = $this->Categories->Companies->find('list', ['limit' => 200]);
        $this->set(compact('category', 'companies'));
    }
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function subCategories($categorie_id)
    {
        $this->loadModel('Subcategories');
        
        $category = $this->Categories->get($categorie_id);
        
        if($category->company_id != $this->request->session()->read('Auth.User.company_id')){
            $this->Flash->error(__('Opas! parece que você não pode editar essa categoria.'));
             return $this->redirect(['action' => 'index']);
        }
        
        $subcategory = $this->Subcategories->newEntity();
        
        if ($this->request->is('post')) {
            $this->request->data['company_id']  = $this->request->session()->read('Auth.User.company_id');
            $this->request->data['category_id'] = $categorie_id;
            $this->request->data['active']      = true;
            $subcategory                        = $this->Subcategories->patchEntity($subcategory, $this->request->getData());
            if ($this->Subcategories->save($subcategory)) {
                $this->Flash->success(__('Subcategoria salva com sucesso.'));
                 return $this->redirect(['action' => 'subcategories', $categorie_id]);
            } else {
                $this->Flash->error(__('A Subcategoria não pode ser salva. Por favor, tente novamente.'));
            }
        }

        $subcategories = $this->Subcategories->find()->where([
            'category_id' => $category->id
        ]);
        
        $this->set(compact('category', 'subcategories', 'subcategory'));
    }

public function subCategoriesEdit($categorie_id, $subcategorie_id)
    {
        $this->loadModel('Subcategories');
        
        $subcategory = $this->Subcategories->get($subcategorie_id, [
            'contain' => []
        ]);
          
        $category = $this->Categories->get($categorie_id);
        
        if($subcategory->company_id != $this->request->session()->read('Auth.User.company_id')){
            $this->Flash->error(__('Opas! parece que você não pode editar essa subcategoria.'));
             return $this->redirect(['action' => 'index']);
        }
        
        
        
       if ($this->request->is(['patch', 'post', 'put'])) {
            
            $subcategory                        = $this->Subcategories->patchEntity($subcategory, $this->request->getData());
            
            if ($this->Subcategories->save($subcategory)) {
                $this->Flash->success(__('Subcategoria salva com sucesso.'));
                 return $this->redirect(['action' => 'subcategories', $categorie_id]);
            } else {
                $this->Flash->error(__('A Subcategoria não pode ser salva. Por favor, tente novamente.'));
            }
        }

        $subcategories = $this->Subcategories->find()->where([
            'category_id' => $category->id
        ]);
        
        
        $this->set(compact('category', 'subcategories', 'subcategory'));
    }

    
    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('Categoria editada com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A categoria não pode ser salva. Por favor, tente novamente.'));
        }
        $companies = $this->Categories->Companies->find('list', ['limit' => 200]);
        $this->set(compact('category', 'companies'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('Categoria deletada com sucesso.'));
        } else {
            $this->Flash->error(__('Categoria não pode ser deletada. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteSubcategorie($id = null)
    {
        $this->loadModel('Subcategories');
        
        $this->request->allowMethod(['post', 'delete']);
        $subcategory = $this->Subcategories->get($id);
        
        $id_category = $subcategory->category_id;
        
        if ($this->Subcategories->delete($subcategory)) {
            $this->Flash->success(__('Subcategoria deletada com sucesso.'));
        } else {
            $this->Flash->error(__('Subcategoria não pode ser deletada. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'subcategories', $id_category]);
    }
    
    /**
     * Organiza o upload.
     * @access public
     * @param Array $imagem
     * @param String $data
     */
    public function upload($id)
    {
        $categories = $this->Categories->get($id,
        [
            'conditions' => [
                'company_id' => $this->request->session()->read('Auth.User.company_id')
            ]
        ]);

        
        $this->request->session()->write('Upload',
            [
            'table'         => 'Categories',
            'column'        => 'url_icon',
            'dir'           => 'categories',
            'max_files'     => 1,
            'max_file_size' => 1000000,
            'download'      => true,
            'types_file'    => ['jpe?g', 'png'],
            'id'            => $categories->id
        ]);

        $this->set('client', $categories);
    }

    }
