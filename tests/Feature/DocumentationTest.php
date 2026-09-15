<?php

namespace Tests\Feature;

use Tests\TestCase;

class DocumentationTest extends TestCase
{
    public function test_public_documentation_pdf_can_be_downloaded(): void
    {
        $response = $this->get(route('documentation.pdf'));

        $response->assertOk()
            ->assertHeader('content-type', 'application/pdf')
            ->assertHeader('content-disposition');
    }
}