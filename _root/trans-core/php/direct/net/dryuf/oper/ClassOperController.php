<?php

namespace net\dryuf\oper;


class ClassOperController extends \net\dryuf\oper\DummyObjectOperController
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			getObjectId($operContext)
	{
		return array();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\AbstractObjectOperController\Actioner')
	*/
	public function			findActioner($actionName)
	{
		if (!is_null(($actioner = parent::findActioner($actionName))))
			return $actioner;
		try {
			$actionController = $this->appContainer->getBean($actionName."-oper");
		}
		catch (\net\dryuf\core\NoSuchBeanException $ex) {
			return null;
		}
		return new \net\dryuf\oper\AbstractObjectOperController\Actioner()(=f_I_x=)
		class  {
		    
		    @Override()
		    public String getActionName() {
		        return actionName;
		    }
		    
		    @Override()
		    public ObjectOperRules getOperRules() {
		        return new ObjectOperRules(){
		            
		            @Override()
		            public Class<? extends Annotation> annotationType() {
		                return null;
		            }
		            
		            @Override()
		            public String value() {
		                return null;
		            }
		            
		            @Override()
		            public String reqRole() {
		                return "";
		            }
		            
		            @Override()
		            public boolean isStatic() {
		                return true;
		            }
		            
		            @Override()
		            public boolean isFinal() {
		                return false;
		            }
		            
		            @SuppressWarnings({"unchecked", "rawtypes"})
		            @Override()
		            public Class<? extends Textual<?>>[] parameters() {
		                return new Class[0];
		            }
		            
		            @Override()
		            public Class<?> actionClass() {
		                return void.class;
		            }
		        };
		    }
		    
		    @Override()
		    public Object runAction(AbstractObjectOperController<?> controller, ObjectOperContext operContext, EntityHolder<?> ownerHolder) {
		        return actionController.operate(operContext, ownerHolder);
		    }
		}(=x_I_f=);
	}
};


?>
