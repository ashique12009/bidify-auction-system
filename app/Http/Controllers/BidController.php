<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Product;
use App\Events\BidPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller {
  /**
   * Place a bid on a product
   */
  public function place(Request $request, Product $product = null) {
    // Handle both route parameter and form input
    $productId = $product ? $product->id : $request->input('product_id');
    $product = Product::findOrFail($productId);

    $request->validate([
      'bid_amount' => 'required|numeric|min:0.01',
    ]);

    // Check if auction is running
    if ($product->status !== 'running') {
      return response()->json(['success' => false, 'message' => 'This auction is not currently running.'], 400);
    }

    // Check if auction has ended
    if ($product->end_time && $product->end_time->isPast()) {
      return response()->json(['success' => false, 'message' => 'This auction has ended.'], 400);
    }

    $bidAmount = $request->input('bid_amount');

    // Check if bid amount is higher than current price
    if ($bidAmount <= $product->current_price) {
      return response()->json(['success' => false, 'message' => 'Bid amount must be higher than the current bid of $' . number_format($product->current_price, 2)], 400);
    }

    // Check if user is trying to bid on their own product
    if ($product->publisher_id === Auth::id()) {
      return response()->json(['success' => false, 'message' => 'You cannot bid on your own product.'], 400);
    }

    // Create the bid
    $bid = Bid::create([
      'product_id' => $product->id,
      'user_id'    => Auth::id(),
      'bid_amount' => $bidAmount,
    ]);

    // Update product's current price
    $product->update([
      'current_price' => $bidAmount,
    ]);

    // Broadcast the bid place
    broadcast(new BidPlaced($bid, $product));

    return response()->json([
      'success' => true,
      'message' => 'Your bid of $' . number_format($bidAmount, 2) . ' has been placed successfully!',
    ]);

    // return back()->with('success', 'Your bid of $' . number_format($bidAmount, 2) . ' has been placed successfully!');
  }

  /**
   * Get bid history for a product
   */
  public function history(Product $product) {
    $bids = $product->bids()->with('user')->latest()->get();
        
    return response()->json([
      'bids' => $bids->map(function ($bid) {
        return [
          'id'     => $bid->id,
          'amount' => $bid->bid_amount,
          'user'   => $bid->user->name,
          'time'   => $bid->created_at->format('M d, Y h:i A'),
        ];
      }),
      'total_bids' => $bids->count(),
    ]);
  }
}
