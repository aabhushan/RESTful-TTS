<?php
Library::import('converter.models.Text');
Library::import('recess.framework.forms.ModelForm');

/**
 * !RespondsWith Layouts
 * !Prefix text/
 */
class TextController extends Controller {
	
	/** @var Text */
	protected $text;
	
	/** @var Form */
	protected $_form;
	
	function init() {
		$this->text = new Text();
		$this->_form = new ModelForm('text', $this->request->data('text'), $this->text);
	}
	
	/** !Route GET */
	function index() {
		$this->textSet = $this->text->all();
		if(isset($this->request->get['flash'])) {
			$this->flash = $this->request->get['flash'];
		}
	}
	
	/** !Route GET, $id */
	function details($id) {
		$this->text->id = $id;
		if($this->text->exists()) {
			return $this->ok('details');
		} else {
			return $this->forwardNotFound($this->urlTo('index'));
		}
	}
	
	/** !Route GET, new */
	function newForm() {
		$this->_form->to(Methods::POST, $this->urlTo('insert'));
		return $this->ok('editForm');
	}
	
	/** !Route POST */
	function insert() {
		try {
			$this->text->insert();
			return $this->created($this->urlTo('details', $this->text->id));		
		} catch(Exception $exception) {
			return $this->conflict('editForm');
		}
	}
	
	/** !Route GET, $id/edit */
	function editForm($id) {
		$this->text->id = $id;
		if($this->text->exists()) {
			$this->_form->to(Methods::PUT, $this->urlTo('update', $id));
		} else {
			return $this->forwardNotFound($this->urlTo('index'), 'Text does not exist.');
		}
	}
	
	/** !Route PUT, $id */
	function update($id) {
		$oldText = new Text($id);
		if($oldText->exists()) {
			$oldText->copy($this->text)->save();
			return $this->forwardOk($this->urlTo('details', $id));
		} else {
			return $this->forwardNotFound($this->urlTo('index'), 'Text does not exist.');
		}
	}
	
	/** !Route DELETE, $id */
	function delete($id) {
		$this->text->id = $id;
		if($this->text->delete()) {
			return $this->forwardOk($this->urlTo('index'));
		} else {
			return $this->forwardNotFound($this->urlTo('index'), 'Text does not exist.');
		}
	}
}
?>