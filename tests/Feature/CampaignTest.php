<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Models\User;

class CampaignTest extends TestCase
{
    use WithFaker;

    /**
     * test create a campaign.
     *
     * @return void
     */
    public function testCreateCampaign()
    {
        $user = User::factory()->create(); 

        $campaignData = [
            "user_id" => $user->id,
            "inputs" => [
                ['type' => "channel",'value' => $this->faker->realText(10)],
                ['type' => "source",'value' => $this->faker->realText(15)],
                ['type' => "campaign_name",'value' => $this->faker->realText(10)],
                ['type' => "target_url",'value' => $this->faker->realText(20)]
            ]
        ];

        $this->json('POST', '/api/campaigns', $campaignData, ['Accept' => 'application/json'])
        ->assertStatus(201);
    }

    /**
     * test list of campaigns.
     *
     * @return void
     */
    public function testListCampaigns()
    {
        $response = $this->get('/api/campaigns');

        $response->assertStatus(200);
    }
}
