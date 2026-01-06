<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ClosetItem;
use App\Models\OutfitAlbum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OutfitAlbumTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Test user can create a new album
     */
    public function test_user_can_create_album()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('closet.album.create'), [
            'name' => 'Casual Weekend',
            'description' => 'Outfit santai akhir pekan',
        ]);

        $response->assertRedirect(route('closet.index'));
        $this->assertDatabaseHas('outfit_albums', [
            'user_id' => $this->user->id,
            'name' => 'Casual Weekend',
        ]);
    }

    /**
     * Test validation on album creation
     */
    public function test_album_creation_requires_name()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('closet.album.create'), [
            'name' => '',
            'description' => 'Test',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test user can view album
     */
    public function test_user_can_view_album()
    {
        $this->actingAs($this->user);

        $album = OutfitAlbum::factory()
            ->for($this->user)
            ->create();

        $response = $this->get(route('closet.album.view', $album));

        $response->assertStatus(200);
        $response->assertViewHas('album', $album);
    }

    /**
     * Test user cannot view other user's album
     */
    public function test_user_cannot_view_other_user_album()
    {
        $otherUser = User::factory()->create();
        $album = OutfitAlbum::factory()
            ->for($otherUser)
            ->create();

        $response = $this->actingAs($this->user)
            ->get(route('closet.album.view', $album));

        $response->assertStatus(403);
    }

    /**
     * Test user can update album
     */
    public function test_user_can_update_album()
    {
        $this->actingAs($this->user);

        $album = OutfitAlbum::factory()
            ->for($this->user)
            ->create();

        $response = $this->patch(route('closet.album.update', $album), [
            'name' => 'Updated Album Name',
            'description' => 'Updated description',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('outfit_albums', [
            'id' => $album->id,
            'name' => 'Updated Album Name',
        ]);
    }

    /**
     * Test user can delete album
     */
    public function test_user_can_delete_album()
    {
        $this->actingAs($this->user);

        $album = OutfitAlbum::factory()
            ->for($this->user)
            ->create();

        $item = ClosetItem::factory()
            ->for($this->user)
            ->create(['outfit_album_id' => $album->id]);

        $response = $this->delete(route('closet.album.destroy', $album));

        $response->assertRedirect(route('closet.index'));
        $this->assertDatabaseMissing('outfit_albums', ['id' => $album->id]);
        
        // Check item moved to unassigned
        $this->assertDatabaseHas('closet_items', [
            'id' => $item->id,
            'outfit_album_id' => null,
        ]);
    }

    /**
     * Test user can add item to album
     */
    public function test_user_can_add_item_to_album()
    {
        $this->actingAs($this->user);

        $album = OutfitAlbum::factory()
            ->for($this->user)
            ->create();

        $item = ClosetItem::factory()
            ->for($this->user)
            ->create(['outfit_album_id' => null]);

        $response = $this->post(
            route('closet.item.add-to-album', $item),
            ['album_id' => $album->id],
            ['Content-Type' => 'application/json']
        );

        $response->assertOk();
        $this->assertDatabaseHas('closet_items', [
            'id' => $item->id,
            'outfit_album_id' => $album->id,
        ]);
    }

    /**
     * Test user can remove item from album
     */
    public function test_user_can_remove_item_from_album()
    {
        $this->actingAs($this->user);

        $album = OutfitAlbum::factory()
            ->for($this->user)
            ->create();

        $item = ClosetItem::factory()
            ->for($this->user)
            ->create(['outfit_album_id' => $album->id]);

        $response = $this->delete(route('closet.item.remove-from-album', $item));

        $response->assertRedirect();
        $this->assertDatabaseHas('closet_items', [
            'id' => $item->id,
            'outfit_album_id' => null,
        ]);
    }

    /**
     * Test user cannot add other user's item to their album
     */
    public function test_user_cannot_add_other_user_item_to_album()
    {
        $otherUser = User::factory()->create();
        
        $this->actingAs($this->user);

        $album = OutfitAlbum::factory()
            ->for($this->user)
            ->create();

        $item = ClosetItem::factory()
            ->for($otherUser)
            ->create();

        $response = $this->post(
            route('closet.item.add-to-album', $item),
            ['album_id' => $album->id],
            ['Content-Type' => 'application/json']
        );

        $response->assertStatus(403);
    }

    /**
     * Test album item count is correct
     */
    public function test_album_items_count_is_correct()
    {
        $album = OutfitAlbum::factory()
            ->for($this->user)
            ->create();

        ClosetItem::factory()
            ->for($this->user)
            ->count(3)
            ->create(['outfit_album_id' => $album->id]);

        $this->assertEquals(3, $album->items()->count());
    }
}
