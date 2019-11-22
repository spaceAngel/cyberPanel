<?php
use CyberPanel\Configuration\MacroList;
use CyberPanel\Configuration\Macro;

$this->addMacrolist(
	(new MacroList())
	->addMacro(
		(new Macro())
		->setCaption('firefox')
		->setIcon('fa-firefox')
		->setCommand('firefox')
	)
	->addMacro(
		(new Macro())
		->setCaption('chrome')
		->setIcon('fa-chrome')
		->setCommand('chromium')
	)
	->addMacro(
		(new Macro())
		->setCaption('files')
		->setIcon('fa-folder')
		->setCommand('krusader')
	)
	->addMacro(
		(new Macro())
		->setCaption('music')
		->setIcon('fa-music')
		->setCommand('audacious')
	)
	->addMacro(
		(new Macro())
		->setCaption('calculator')
		->setIcon('fa-calculator')
		->setCommand('kcalc')
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