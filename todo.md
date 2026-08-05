# Database Optimization Guide for Laravel (2+ Years Experience)

## 🎯 Why These Concepts Matter for Senior Developers

As a full-stack developer with 2+ years experience, you're expected to:
- **Design scalable database schemas** that handle thousands of concurrent users
- **Optimize query performance** to keep response times under 200ms
- **Prevent data inconsistencies** in complex business transactions
- **Handle race conditions** in high-traffic applications
- **Maintain data integrity** while supporting soft deletes and cascading operations

---

## 1️⃣ PRIMARY KEY & FOREIGN KEY

### **When to Use**
- **Always** use primary keys (obviously)
- **Foreign keys**: When you have relationships that must maintain referential integrity

### **Why It Matters for Senior Devs**
- Prevents orphan records
- Enforces data consistency at database level (not just application level)
- Improves join performance (FKs are automatically indexed in most DBs)

```php
// Migration Example
Schema::create('orders', function (Blueprint $table) {
    $table->id(); // Primary key
    $table->foreignId('user_id')
          ->constrained('users')
          ->onDelete('cascade')
          ->onUpdate('cascade');
    $table->string('order_number')->unique();
    $table->timestamps();
});

// Model Relationships
class Order extends Model
{
    protected $fillable = ['user_id', 'order_number'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

---

## 2️⃣ UNIQUE INDEX

### **When to Use**
- Emails, usernames, order numbers
- Composite unique keys (e.g., `user_id` + `product_id` in cart)

### **Why It Matters**
- Prevents duplicate data at database level
- Faster than checking in PHP
- Provides built-in validation

```php
// Single Column Unique
Schema::table('users', function (Blueprint $table) {
    $table->string('email')->unique();
});

// Composite Unique Index
Schema::table('cart_items', function (Blueprint $table) {
    $table->unique(['user_id', 'product_id']);
});

// In Model
class User extends Model
{
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email'
        ];
    }
}
```

---

## 3️⃣ FULL TEXT INDEX

### **When to Use**
- Search functionality (articles, products, comments)
- When you need `LIKE '%keyword%'` performance
- Natural language search

### **Why It Matters for Senior Devs**
- `LIKE '%term%'` is O(n) - terrible for large tables
- Full-text search is optimized for text searching (uses inverted indexes)
- Supports relevance scoring

```php
// Migration
Schema::table('articles', function (Blueprint $table) {
    $table->fullText(['title', 'content']);
});

// Query
// Using MySQL full-text search
$articles = Article::whereRaw(
    "MATCH(title, content) AGAINST(? IN BOOLEAN MODE)", 
    ['+laravel +optimization']
)->get();

// Using Laravel Scout with Algolia/MeiliSearch (recommended for complex search)
class Article extends Model
{
    use Searchable;
    
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}
```

---

## 4️⃣ DATABASE INDEXING (General)

### **When to Use**
- Columns used in `WHERE` clauses
- Columns used in `JOIN` conditions
- Columns used in `ORDER BY`
- Columns used in `GROUP BY`

### **Why It Matters**
- **Indexes make reads faster, writes slower** - this is crucial knowledge
- Indexing strategy is about trade-offs
- Senior devs know when to index and when not to

```php
// Migration with indexes
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->decimal('price', 10, 2);
    $table->boolean('is_active');
    $table->timestamp('created_at');
    
    // Single column indexes
    $table->index('price');
    $table->index('created_at');
    
    // Composite index (covered in next section)
    $table->index(['is_active', 'price']);
});

// Query that uses indexes
$products = Product::where('is_active', true)
                   ->whereBetween('price', [100, 500])
                   ->orderBy('created_at', 'desc')
                   ->get();
```

---

## 5️⃣ COMPOSITE INDEX

### **When to Use**
- Multiple columns frequently used together in WHERE clauses
- Columns used in both WHERE and ORDER BY
- Covering indexes (include all columns needed for query)

### **Why It Matters for Senior Devs**
- **Column order in composite index matters** - most selective first
- Reduces need for separate single-column indexes
- Can make queries 10-100x faster

```php
// Migration
Schema::table('products', function (Blueprint $table) {
    // Most selective column first
    $table->index(['category_id', 'is_active', 'price']);
});

// Example: This query will use the composite index
Product::where('category_id', 5)
       ->where('is_active', true)
       ->where('price', '>', 100)
       ->get();

// Example: This WILL NOT use the composite index effectively
Product::where('is_active', true)
       ->where('price', '>', 100)
       ->get();
// Because category_id is first in index
```

---

## 6️⃣ EXPLAIN QUERY & QUERY OPTIMIZATION

### **When to Use**
- Whenever a query is slow (>200ms)
- Before deploying new features
- When database grows significantly

### **Why It Matters**
- Senior devs profile queries, they don't guess
- EXPLAIN shows execution plan, index usage, row scans
- Helps identify missing indexes or inefficient queries

```php
// Using DB::getQueryLog()
DB::enableQueryLog();
$users = User::with('posts')->get();
dump(DB::getQueryLog());

// Manual EXPLAIN in Laravel
DB::statement('EXPLAIN SELECT * FROM users WHERE email = ?', ['test@example.com']);

// Optimized query examples
// ❌ Bad - N+1 problem
$users = User::all();
foreach ($users as $user) {
    $posts = $user->posts; // N queries
}

// ✅ Good - Eager loading
$users = User::with('posts')->get();

// ❌ Bad - Selecting unnecessary columns
$users = User::all();

// ✅ Good - Select only needed columns
$users = User::select('id', 'name', 'email')->get();

// ❌ Bad - Heavy aggregate in PHP
$users = User::all();
$avg = $users->avg('age');

// ✅ Good - Aggregate in database
$avg = User::avg('age');
```

---

## 7️⃣ DATABASE TRANSACTIONS

### **When to Use**
- Multiple operations that must succeed or fail together
- Financial operations, order processing, inventory management
- Any operation that modifies multiple tables

### **Why It Matters for Senior Devs**
- Prevents data corruption
- Maintains ACID properties
- Essential for business-critical applications

```php
// Basic Transaction
DB::transaction(function () {
    $order = Order::create(['user_id' => 1]);
    $order->items()->createMany([...]);
    $order->payment()->create([...]);
    Inventory::where('product_id', 5)->decrement('quantity', 2);
});

// Manual Transaction with Exception Handling
DB::beginTransaction();
try {
    $user = User::create([...]);
    $profile = Profile::create(['user_id' => $user->id, ...]);
    $wallet = Wallet::create(['user_id' => $user->id, 'balance' => 0]);
    
    // Some validation
    if ($someCondition) {
        throw new \Exception('Validation failed');
    }
    
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    Log::error('Transaction failed: ' . $e->getMessage());
    throw $e;
}

// Nested Transactions (Laravel uses savepoints)
DB::transaction(function () {
    DB::transaction(function () {
        // This creates a savepoint
    });
});
```

---

## 8️⃣ ROW LOCKING

### **When to Use**
- Prevent race conditions when updating same record
- Inventory management (avoid overselling)
- Banking operations (avoid double spending)

### **Why It Matters for Senior Devs**
- Prevents lost updates in concurrent environments
- Critical for e-commerce, banking, booking systems
- Must be used with transactions

```php
// Pessimistic Locking
DB::transaction(function () {
    // Locks the row for update - other queries must wait
    $product = Product::where('id', 5)->lockForUpdate()->first();
    
    if ($product->stock > 0) {
        $product->decrement('stock');
        Order::create([...]);
    }
});

// Shared Lock (read lock)
DB::transaction(function () {
    $product = Product::where('id', 5)->sharedLock()->first();
    // Other transactions can read but not write
    // Useful for reading data that might change
});

// Lock with timeout (prevent deadlocks)
DB::statement('SET innodb_lock_wait_timeout = 5');
DB::transaction(function () {
    Product::where('id', 5)->lockForUpdate()->first();
});
```

---

## 9️⃣ OPTIMISTIC LOCKING

### **When to Use**
- When conflicts are rare
- Performance is critical (no row locks)
- Data versioning scenarios

### **Why It Matters for Senior Devs**
- Alternative to pessimistic locking
- Better performance for read-heavy applications
- Uses version numbers or timestamps

```php
// Using version column
Schema::table('products', function (Blueprint $table) {
    $table->integer('version')->default(1);
});

// Model with optimistic locking
class Product extends Model
{
    public function updateWithOptimisticLock(array $data)
    {
        $currentVersion = $this->version;
        
        $updated = $this->where('id', $this->id)
                        ->where('version', $currentVersion)
                        ->update(array_merge($data, ['version' => $currentVersion + 1]));
        
        if ($updated === 0) {
            throw new \Exception('Record was modified by another user');
        }
        
        $this->refresh();
        return true;
    }
}

// Usage
DB::transaction(function () use ($product) {
    try {
        $product->updateWithOptimisticLock(['price' => 100]);
    } catch (\Exception $e) {
        // Retry or notify user
    }
});

// Using Laravel's built-in timestamp check
$product = Product::find(1);
$product->updated_at = now(); // Model automatically handles this
$product->save();
// If updated_at has changed, save will fail
```

---

## 🔟 SOFT DELETE

### **When to Use**
- When you need to recover deleted data
- Audit trails and history
- User accounts (disable instead of delete)
- Regulatory compliance (GDPR exceptions)

### **Why It Matters for Senior Devs**
- More common than actual deletion in enterprise apps
- Must be considered in all queries (scope by default)
- Affects performance (additional WHERE clause)

```php
// Migration
Schema::table('users', function (Blueprint $table) {
    $table->softDeletes();
});

// Model
class User extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
}

// Queries
$users = User::all(); // Excludes soft-deleted
$users = User::withTrashed()->get(); // Includes soft-deleted
$users = User::onlyTrashed()->get(); // Only soft-deleted
$user->restore(); // Restore soft-deleted
$user->forceDelete(); // Permanently delete

// Performance consideration
// ❌ Bad - Soft delete adds WHERE deleted_at IS NULL to every query
// ✅ Good - Index deleted_at column
Schema::table('users', function (Blueprint $table) {
    $table->index('deleted_at');
});

// Creating a global scope to exclude soft-deletes
protected static function boot()
{
    parent::boot();
    static::addGlobalScope('not_deleted', function (Builder $builder) {
        $builder->whereNull('deleted_at');
    });
}
```

---

## 1️⃣1️⃣ CASCADING

### **When to Use**
- `ON DELETE CASCADE`: When child records should be deleted with parent
- `ON DELETE SET NULL`: When you want to keep child records but remove reference
- `ON DELETE RESTRICT`: When you want to prevent deletion if children exist

### **Why It Matters for Senior Devs**
- Maintains referential integrity
- Prevents orphan records
- Database-level enforcement (not application-level)

```php
// Migration with cascade
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')
          ->constrained()
          ->onDelete('cascade')
          ->onUpdate('cascade');
    $table->text('content');
    $table->timestamps();
});

// Multiple levels
Schema::create('comments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('post_id')
          ->constrained()
          ->onDelete('cascade'); // Deletes comments when post is deleted
    $table->text('content');
    $table->timestamps();
});

// Model-level cascade (if not using DB-level)
class Post extends Model
{
    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($post) {
            if (!$post->isForceDeleting()) {
                // Soft delete related records
                $post->comments()->delete();
            } else {
                // Force delete related records
                $post->comments()->forceDelete();
            }
        });
    }
}
```

---

## 🚀 Real-World Example: E-commerce Order Processing

```php
class OrderService
{
    public function createOrder(array $data)
    {
        DB::transaction(function () use ($data) {
            // 1. Lock inventory with row lock
            $product = Product::where('id', $data['product_id'])
                             ->lockForUpdate()
                             ->first();
            
            if ($product->stock < $data['quantity']) {
                throw new \Exception('Insufficient stock');
            }
            
            // 2. Create order
            $order = Order::create([
                'user_id' => $data['user_id'],
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
                'status' => 'pending'
            ]);
            
            // 3. Update inventory with optimistic lock
            $updated = Product::where('id', $product->id)
                             ->where('version', $product->version)
                             ->update([
                                 'stock' => $product->stock - $data['quantity'],
                                 'version' => $product->version + 1
                             ]);
            
            if ($updated === 0) {
                throw new \Exception('Inventory was modified. Please try again.');
            }
            
            // 4. Process payment
            $payment = $this->processPayment($order);
            
            // 5. Update order status
            $order->update(['status' => 'paid', 'payment_id' => $payment->id]);
            
            // 6. Create notification
            $this->createNotification($order);
            
            return $order;
        });
    }
}
```

## 🎯 Performance Checklist

| Concept | When to Use | Example Scenario |
|---------|-------------|------------------|
| **Composite Index** | Filtering on multiple columns | `WHERE user_id = 1 AND status = 'active'` |
| **Full Text Index** | Text search | Search articles, products description |
| **Transactions** | Multiple related writes | Order processing, money transfer |
| **Row Locking** | Inventory update | Buying products, seat booking |
| **Optimistic Locking** | Occasional conflicts | User profile updates, document editing |
| **Soft Delete** | Data recovery needed | User accounts, records with audit trail |
| **Cascade Delete** | Child records deletion | Delete user → delete posts → delete comments |

---

## 🔍 Advanced Query Optimization Examples

```php
// ❌ Bad - Using like on unindexed column
User::where('email', 'LIKE', '%gmail.com%')->get();

// ✅ Good - Use full text or index column
User::where('email_domain', 'gmail.com')->get();

// ❌ Bad - Using functions on indexed columns
User::where(DB::raw('YEAR(created_at)'), 2024)->get();

// ✅ Good - Use range query
User::whereBetween('created_at', ['2024-01-01', '2024-12-31'])->get();

// ❌ Bad - N+1 with count
$users = User::all();
foreach ($users as $user) {
    $postCount = $user->posts()->count();
}

// ✅ Good - Use withCount
$users = User::withCount('posts')->get();

// ❌ Bad - Using OR with different columns
User::where('email', 'test@test.com')->orWhere('username', 'test')->get();

// ✅ Good - Use union or separate queries with index
User::where('email', 'test@test.com')->union(
    User::where('username', 'test')
)->get();
```

This guide covers everything a 2+ year experienced developer needs for database optimization in Laravel. Remember: **Profile before optimizing** and **always test with production-like data**.




==========>
1. Authentication and Authorization:
✅remember me
✅password reset

2. Security
✅csrf
✅cors
✅xss
✅sql injection
✅mass assignment
✅rate limiting
password hashing
encryption
api tokne

3. api development
pagination
filtering
sorting
searching
api versioning
resource
error response
validation
api documentation
OpenAPI/ Swagger

4. PHPUnit 
Pest
Feature Test
Unit Test
API Test
React Testing Library
vitest
Cypress

