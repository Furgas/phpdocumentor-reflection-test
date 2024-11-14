<?php
declare(strict_types=1);

use App\Foo;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Types\ContextFactory;

require_once __DIR__ . '/vendor/autoload.php';

$doc_block_factory = DocBlockFactory::createInstance();
$context_factory = new ContextFactory();

$foo = new Foo();
$foo_class = new \ReflectionClass($foo);

foreach ($foo_class->getMethods() as $method) {
	$method_docblock = $doc_block_factory->create(
		$method,
		$context_factory->createFromReflector($method)
	);

	/** @var Param[] $param_tags */
	$param_tags = $method_docblock->getTagsByName('param');
	foreach ($param_tags as $param_tag) {
		printf(
			"%s::%s(), $%s:\n%s\n",
			$foo_class->getName(),
			$method->getName(),
			$param_tag->getVariableName(),
			$param_tag->getDescription()
		);
	}
}

