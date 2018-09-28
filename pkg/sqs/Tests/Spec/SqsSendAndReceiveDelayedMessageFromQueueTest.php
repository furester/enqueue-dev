<?php

namespace Enqueue\Sqs\Tests\Spec;

use Enqueue\Sqs\SqsContext;
use Enqueue\Sqs\SqsDestination;
use Enqueue\Test\RetryTrait;
use Enqueue\Test\SqsExtension;
use Interop\Queue\Context;
use Interop\Queue\Spec\SendAndReceiveDelayedMessageFromQueueSpec;

/**
 * @group functional
 * @retry 5
 */
class SqsSendAndReceiveDelayedMessageFromQueueTest extends SendAndReceiveDelayedMessageFromQueueSpec
{
    use RetryTrait;
    use SqsExtension;

    /**
     * @var SqsContext
     */
    private $context;

    /**
     * @var SqsDestination
     */
    private $queue;

    protected function tearDown()
    {
        parent::tearDown();

        if ($this->context && $this->queue) {
            $this->context->deleteQueue($this->queue);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function createContext()
    {
        return $this->context = $this->buildSqsContext();
    }

    /**
     * {@inheritdoc}
     *
     * @param SqsContext $context
     */
    protected function createQueue(Context $context, $queueName)
    {
        $queueName = $queueName.time();

        $this->queue = $context->createQueue($queueName);
        $context->declareQueue($this->queue);

        return $this->queue;
    }
}
