<?php

namespace Psalm\Tests\Template;

use Psalm\Tests\TestCase;
use Psalm\Tests\Traits;

final class ClassMethodTemplateConstraintTest extends TestCase
{
    use Traits\ValidCodeAnalysisTestTrait;
    use Traits\InvalidCodeAnalysisTestTrait;

    /**
     * @return iterable<string,array{string,assertions?:array<string,string>,error_levels?:string[]}>
     */
    public function providerValidCodeParse()
    {
        return [
            'validConstraint' => [
                '<?php

                    /**
                     * @template T
                     */
                    class Foo
                    {
                      /**
                       * @psalm-constraint T string
                       */
                      public function bar(): void {}
                    }
                    
                    /** @var Foo<string> $foo */
                    $foo = new Foo();
                    
                    $foo->bar();'
            ]
        ];
    }

    /**
     * @return iterable<string,array{string,error_message:string,2?:string[],3?:bool,4?:string}>
     */
    public function providerInvalidCodeParse()
    {
        return [
            'invalidConstraint' => [
                '<?php

                    /**
                     * @template T
                     */
                    class Foo
                    {
                      /**
                       * @psalm-constraint T string
                       */
                      public function bar(): void {}
                    }
                    
                    /** @var Foo<int> $foo */
                    $foo = new Foo();
                    
                    $foo->bar();',
                'error_message' => 'ConstraintNotSatisfied'
            ]
        ];
    }
}
