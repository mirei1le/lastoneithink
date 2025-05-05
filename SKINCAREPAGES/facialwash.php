

<!-- REVIEW SECTION -->
<div class="review-section" style="margin-top: 30px;">
    <h2>Product Reviews</h2>
    <p>No reviews yet. Be the first to review!</p>
    <div class="write-review" style="margin-top: 20px;">
        <h3>Write a Review</h3>
        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="submit_review.php" method="post">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($_GET['product_id']) ?>">

                <div class="form-group">
                    <label for="reviewer_name">Your Name:</label>
                    <input type="text" id="reviewer_name" name="reviewer_name" required>
                </div>

                <div class="rating-input">
                    <label>Rating:</label>
                    <select name="rating" required>
                        <option value="">Select rating</option>
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="review_text">Your Review:</label>
                    <textarea id="review_text" name="review_text" rows="4" required></textarea>
                </div>

                <button type="submit" class="add-to-bag">Submit Review</button>
            </form>
        <?php else: ?>
            <div class="login-prompt" style="margin-top: 10px;">
                <a href="signup_login.php" class="add-to-bag">Log in to make a review</a>
            </div>
        <?php endif; ?>
    </div>
</div>
