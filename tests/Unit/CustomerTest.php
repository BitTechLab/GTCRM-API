<?php

namespace Tests\Unit;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    // use RefreshDatabase;
    use DatabaseTruncation;
    protected CustomerRepositoryInterface $customerRepository;

    private array $customers = [
        [
            'name' => 'customer one',
            'email' => 'customerone@test.com',
        ],
        [
            'name' => 'customer two',
            'email' => 'customertwo@test.com',
        ],
        [
            'name' => 'customer three',
            'email' => 'customerthree@test.com',
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();

        // Set up any dependencies or perform actions required before each test
        $this->customerRepository = new CustomerRepository();
    }

    public function test_customer_getAll(): void
    {
        $this->addToDatabase(0);
        $this->addToDatabase(1);

        $customers = $this->customerRepository->getAll();

        $this->assertEquals($customers->count(), 2);

        $this->assertEquals($customers->first()['name'], 'customer one');
    }

    public function test_customer_getById(): void
    {
        $this->addToDatabase(0);

        $customer = $this->customerRepository->getById(1);

        $this->assertEquals($customer->id, 1);
    }

    public function test_customer_delete(): void
    {
        $this->addToDatabase(0);
        $this->addToDatabase(1);

        $customer = $this->customerRepository->getById(1);

        $this->assertEquals($customer->id, 1);

        $this->customerRepository->delete(1);

        try {
            $customer = $this->customerRepository->getById(1);
        } catch (\Exception $e) {
        } finally {
            $this->assertInstanceOf(\Exception::class, $e);
        }

        $customers = $this->customerRepository->getAll();

        $this->assertEquals($customers->count(), 1);
    }

    public function test_customer_create(): void
    {
        $this->customerRepository->create($this->customers[0]);

        $customer = $this->customerRepository->getById(1);

        $this->assertNotNull($customer);
    }

    public function test_customer_update(): void
    {
        $this->addToDatabase(0);

        $this->customerRepository->update(1, [
            'name' => 'changed',
        ]);

        $customer = $this->customerRepository->getById(1);

        $this->assertEquals($customer->name, 'changed');
    }

    private function addToDatabase(int $index)
    {
        $this->customerRepository->create($this->customers[0]);
    }
}
