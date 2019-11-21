<?php
use CyberPanel\Configuration\MacroList;
use CyberPanel\Configuration\Macro;

$this->addMacrolist(
	(new MacroList())
	->addMacro(
		(new Macro())
		->setCaption('firefox')
		->setIcon('fa-firefox')
	)
	->addMacro(
		(new Macro())
		->setCaption('chrome')
		->setIcon('fa-chrome')
	)
	->addMacro(
		(new Macro())
		->setCaption('files')
		->setIcon('fa-folder')
	)
	->addMacro(
		(new Macro())
		->setCaption('music')
		->setIcon('fa-music')
	)
	->addMacro(
		(new Macro())
		->setCaption('calculator')
		->setIcon('fa-calculator')
	)
	->addMacro(
		(new Macro())
		->setCaption('email')
		->setIcon('fa-envelope')
	)
	->addMacro(
		(new Macro())
		->setCaption('terminal')
		->setIcon('fa-terminal')
	)
	->addMacro(
		(new Macro())
		->setCaption('ecllipse')
		->setIcon('fa-code')
	)
);