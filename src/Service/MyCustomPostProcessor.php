<?php
namespace App\Service;

use Liip\ImagineBundle\Binary\BinaryInterface;
use Liip\ImagineBundle\Model\Binary;
use Liip\ImagineBundle\Imagine\Filter\PostProcessorInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ProcessBuilder;

class MyCustomPostProcessor implements PostProcessorInterface
{
    public const EXECUTABLE_PATH = '/path/to/your/executable';

    /**
     * @param BinaryInterface $binary
     *
     * @return BinaryInterface
     */
    public function process(BinaryInterface $binary)
    {
        // ensure the passed binary is a png
        if (!in_array(strtolower($binary->getMimeType()), ['image/png'])) {
            return $binary;
        }

        // create a temporary input file
        if (false === $input = tempnam($path = sys_get_temp_dir(), 'custom_')) {
            throw new \Exception(sprintf('Error created tmp file in "%s".', $path));
        }

        // populate temporary file with passed file contents
        file_put_contents($input, $binary->getContent());

        // create a process builder, add the input file as argument
        $pb = new ProcessBuilder([self::EXECUTABLE_PATH]);
        $pb->add($input);

        // get a process instance and run it
        $process = $pb->getProcess();
        $process->run();

        // error out if command returned non-zero
        if (0 !== $process->getExitCode()) {
            unlink($input);
            throw new ProcessFailedException($process);
        }

        // retrieve the result
        $result = new Binary(
            file_get_contents($input),
            $binary->getMimeType(),
            $binary->getFormat()
        );

        // remove temporary file
        unlink($input);

        // return the result
        return $result;
    }
}