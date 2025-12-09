// src/Command/MyCommand.php (CakePHP 4.x/5.x)
namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class MyCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        // Your cron job logic here
        $io->out('My cron job executed successfully!');
    }

    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->addArgument('param1', [
            'help' => 'An example parameter.'
        ]);
        return $parser;
    }
}