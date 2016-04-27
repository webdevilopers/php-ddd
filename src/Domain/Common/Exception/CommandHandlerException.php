<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Common\Exception;

use Example\Domain\Common\Application\CommandHandler;
use Example\Domain\Common\Application\DomainCommand;

final class CommandHandlerException extends \Exception
{
    /**
     * @param DomainCommand $command
     * @param CommandHandler $handler
     *
     * @return CommandHandlerException
     */
    public static function unsupportedCommandException(DomainCommand $command, CommandHandler $handler)
    {
        $commandClass = get_class($command);
        $handlerClass = get_class($handler);

        return new self("The command handler '{$handlerClass}' do not support the command '{$commandClass}'.");
    }
}
