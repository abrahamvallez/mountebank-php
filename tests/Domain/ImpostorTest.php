<?php

namespace MountebankPHP\Tests\Domain;

use MountebankPHP\Domain\Imposter;
use MountebankPHP\Domain\Stub;
use PHPUnit_Framework_TestCase;

/**
 * Class ImpostorTest
 */
class ImpostorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test getJsonDefinition return a json.
     */
    public function testGetJsonDefinitionReturnAJson()
    {
        $impostor = new Imposter();
        $impostor->setPort(4545);
        $impostor->setProtocol(Imposter::HTTP_PROTOCOL);
        $impostor->addStub(new Stub());

        $this->assertJson($impostor->getJsonDefinition());
    }

    /**
     * Test getJsonDefinition return a correct json.
     */
    public function testGetJsonDefinitionReturnACorrectJson()
    {
        $port = 4545;
        $stubDefinition = json_encode([
            'responses' => 'response_mock_from_stub',
            'predicates' => 'predicate_mock_from_stub'
        ]);

        $impostorJsonDefinition = json_encode([
            'port' => $port,
            'protocol' => Imposter::HTTP_PROTOCOL,
            'stubs' => [
                [
                    'responses' => 'response_mock_from_stub',
                    'predicates' => 'predicate_mock_from_stub'
                ]
            ]
        ]);

        $impostor = new Imposter();
        $impostor->setPort(4545);
        $impostor->setProtocol(Imposter::HTTP_PROTOCOL);
        $stub = new Stub();
        $stub->setStubJsonDefinition($stubDefinition);
        $impostor->addStub($stub);

        $this->assertJsonStringEqualsJsonString($impostorJsonDefinition, $impostor->getJsonDefinition());
    }
}
