<?php


namespace app\controllers;
use app\machina\Controller;
use app\machina\Request;
use app\machina\Response;
use app\machina\Application;
use app\models\User;
use app\models\LoginForm;

/**
 * Description of AuthenticationController
 *
 * @author darko
 */
class AuthenticationController extends Controller {
    
    public function login(Request $request, Response $response) {
                
        $loginForm = new LoginForm();
        if($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if($loginForm->validate() && $loginForm->login()) {
                $response->redirect('/');                
                return;
            }
        }
        $this->setLayout('auth');
        
        return $this->render('login', [
            'model' => $loginForm
        ]);
        
    }
    
    public function register(Request $request) {
        
        $user = new User();         
        
        if($request->isPost()) {
                        
            $user->loadData($request->getBody());                        
            
            if($user->validate() && $user->save()) {
                Application::$app->session->setFlash('success', 'You are registered');
                Application::$app->response->redirect('/');
                exit;
            }
                       
            
            return $this->render('register', [
                'model' => $user
            ]);
            
        }
        
        $this->setLayout('auth');
        return $this->render('register', [
                'model' => $user
        ]);
        
    }
    
    public function logout(Request $request, Response $response) {
        
        Application::$app->logout();
        $response->redirect('/');
        
    }
    
}
