<?php

namespace Core\CLI;

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConsoleUI
{
    public static function getIO(): SymfonyStyle
    {
        $input = new ArgvInput();
        $output = new ConsoleOutput();
        return new SymfonyStyle(input: $input, output: $output);
    }

    public static function title(string $title): void
    {
        self::getIO()->title(message: $title);
    }
    
    public static function ask(string $question, ?string $default = null): mixed
    {
        return self::getIO()->ask(question: $question, default: $default);
    }

    public static function progressDemo(string $message, int $steps = 5): void
    {
        $io = self::getIO();
        $io->writeln(messages: $message);
        
        $progressBar = $io->createProgressBar(max: $steps);
        $progressBar->start();
        
        for ($i = 0; $i < $steps; $i++) {
            usleep(microseconds: 200000);
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $io->newLine(count: 2);
    }

    public static function success(string $message): void
    {
        self::getIO()->success(message: $message);
    }

    public static function warning($text): void {
        self::getIO()->warning(message: $text);
    }

    public static function info($text): void {
        self::getIO()->text(message: "<info>$text</info>");
    }

    public static function table($headers, $rows): void {
        self::getIO()->table(headers: $headers, rows: $rows);
    }
}
