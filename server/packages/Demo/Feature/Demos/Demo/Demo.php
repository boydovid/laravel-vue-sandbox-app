<?php

declare(strict_types=1);

namespace Packages\Demo\Feature\Demos\Demo;

use App\Models\Demo as DataModel;

class Demo
{
    public function __construct(
        private string $name,
        private ?int $id = null,
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toDataModel(): DataModel
    {
        return new DataModel([
            'id' => $this->getId(),
            'name' => $this->getName(),
        ]);
    }

    public function generateUuid(): string
    {
        // generate 16 bytes of random data
        $data = random_bytes(16);
        // $data = "";
        // for ($i = 0; $i < 16; $i++) {
        //     $data .= chr(mt_rand(0, 255));
        // }

        // replace the version byte with the value 4
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        // replace the other 2 reserved bits with the fixed value
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        // format the UUID as a string
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
