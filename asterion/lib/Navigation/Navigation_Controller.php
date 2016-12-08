<?php
/**
* @class NavigationController
*
* This is the controller for all the public actions of the website.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Navigation_Controller extends Controller{

    /**
    * The constructor of the object.
    */
    public function __construct($GET, $POST, $FILES) {
        parent::__construct($GET, $POST, $FILES);
        $this->ui = new Navigation_Ui($this);
    }
    
    /**
    * Main function to control the public actions.
    */
    public function controlActions(){
        switch ($this->action) {
            default:
                $this->metaUrl = url('');
                $this->content = '<section class="pageBlock pageBlockIntro">
                                        <div class="pageBlockIns">
                                            <h1>'.Params::param('metainfo-metaDescription-'.Lang::active()).'</h1>
                                            <div class="introButtons">
                                                <a href="https://github.com/asterion-cms/asterion/archive/master.zip" class="introButton introButtonDownload" target="_blank">'.__('download').' <span>v.4.0.1</span></a>
                                                <a href="'.url('demo').'" class="introButton" target="_blank">'.__('tryDemo').'</a>
                                                <a href="'.url('github').'" class="introButton" target="_blank">'.__('viewGitHub').'</a>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="pageBlock pageBlockMain">
                                        <div class="pageBlockContent">
                                            '.HtmlSection::show('intro').'
                                        </div>
                                    </section>
                                    <section class="pageBlock pageBlockWhen">
                                        <div class="pageBlockContent">
                                            '.HtmlSection::show('when-to-use').'
                                        </div>
                                    </section>
                                    <section class="pageBlock pageBlockExamples">
                                        <div class="pageBlockContent">
                                            '.HtmlSection::show('examples').'
                                            '.HtmlSection::show('brands').'
                                            '.Brand_Ui::intro().'
                                        </div>
                                    </section>
                                    <section class="pageBlock pageBlockDocumentation">
                                        <div class="pageBlockContent">
                                            '.HtmlSection::show('documentation').'
                                        </div>
                                    </section>';
            break;
            case 'documentation':
                $info = explode('_', $this->id);
                $item = Documentation::read($info[0]);
                $item = ($item->id()=='') ? $item->readFirstObject(array('order'=>'ord')) : $item;
                $this->layoutPage = 'documentation';
                $this->titlePage = $item->getBasicInfo();
                $this->metaDescription = $item->get('shortDescription');
                $this->metaUrl = $item->url();
                $this->content = $item->showUi('Complete');
            break;
            case 'about-us':
                $this->layoutPage = 'simple';
                $page = Page::code($this->action);
                $this->titlePage = $page->getBasicInfo();
                $this->metaDescription = $page->get('metaDescription');
                $this->metaKeywords = $page->get('metaKeywords');
                $this->metaUrl = url($this->action);
                $this->content = $page->showUi('Complete');
            break;
            case 'contact':
                $this->layoutPage = 'simple';
                $page = Page::code($this->action);
                $this->titlePage = $page->getBasicInfo();
                $this->metaUrl = url($this->action);
                if ($this->id == 'thanks') {
                    $this->message = __('thanksMessage');
                }
                if (count($this->values)>0) {
                    $form = new Contact_Form($this->values);
                    $errors = $form->isValid();
                    if (count($errors)>0) {
                        $this->content = Contact_Ui::intro(array('values'=>$this->values, 'errors'=>$errors));
                    } else {
                        $contact = new Contact();
                        $contact->insert($this->values);
                        HtmlMail::send(Params::param('email-contact'), 'notification', array('CONTENT'=>$contact->showUi('Email')));
                        header('Location: '.url($this->action.'/thanks'));
                        exit();
                    }
                } else {
                    $this->content = Contact_Ui::intro();
                }
            break;
            case 'github':
                $this->mode = 'ajax';
                header('Location: '.Url::format(Params::param('linksocial-github')));
                exit();
            break;
            case 'error':
                header("HTTP/1.0 404 Not Found");
                $this->titlePage = 'Error 404';
                $this->content = 'Error 404';
            break;
        }
        return $this->ui->render();
    }

}
?>