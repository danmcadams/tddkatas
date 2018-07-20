<?php declare(strict_types=1);


namespace Kata\Greeting;


class Greeter
{
    const BASE_GREETING  = 'Hello, %s.';
    const SHOUT_GREETING = 'HELLO %s!';

    protected $standardNames = [];
    protected $shoutingNames = [];

    public function greet($name = null)
    {
        if (empty($name)) {
            return sprintf(self::BASE_GREETING, 'my friend');
        }
        if (is_string($name) && $this->isShouting($name)) {
            return sprintf(self::SHOUT_GREETING, $name);
        }
        if (is_array($name)) {
            $this->extractStandardNames($name);
            $this->extractShoutingNames($name);

            return $this->getArrayGreeting();
        }
        return sprintf(self::BASE_GREETING, $name);
    }

    private function isShouting(string $name)
    {
        return strtoupper($name) === $name;
    }

    private function getArrayGreeting()
    {
        $greeting = '';

        if (!empty($this->standardNames)) {
            $greeting .= $this->getStandardGreeting();
        }
        if (!empty($this->standardNames && !empty($this->shoutingNames))) {
            $greeting .= ' AND ';
        }
        if (!empty($this->shoutingNames)) {
            $greeting .= $this->getShoutingGreeting();
        }
        return $greeting;
    }

    private function extractStandardNames($names)
    {
        foreach ($names as $name) {
            if (!$this->isShouting($name)) {
                if (!preg_match('/^\"[\s\S]+\"$/', $name, $match)) {
                    foreach (explode(',', $name) as $expName) {
                        $this->standardNames[] = trim($expName);
                    }
                    continue;
                }
                $this->standardNames[] = str_replace('"', '', $name);
            }
        }
    }

    private function extractShoutingNames($names)
    {
        foreach ($names as $name) {
            if ($this->isShouting($name)) {
                $this->shoutingNames[] = $name;
            }
        }
    }

    private function getStandardGreeting(): string
    {
        if (2 === count($this->standardNames)) {
            return sprintf(self::BASE_GREETING, implode(' and ', $this->standardNames));
        }
        $lastStandardName = end($this->standardNames);

        array_pop($this->standardNames);

        if (2 <= count($this->standardNames)) {
            return sprintf(self::BASE_GREETING, implode(', ', $this->standardNames) . ', and ' . $lastStandardName);
        }

        return '';
    }

    private function getShoutingGreeting()
    {
        return sprintf(self::SHOUT_GREETING, $this->shoutingNames[0]);
    }
}
