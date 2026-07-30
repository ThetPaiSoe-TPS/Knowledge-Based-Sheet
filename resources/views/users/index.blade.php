<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
        }

        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 5px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filters input,
        .filters select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .filters button {
            padding: 8px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .filters .clear-btn {
            background: #666;
            text-decoration: none;
            color: white;
            padding: 8px 20px;
            border-radius: 4px;
            display: inline-block;
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .status-active {
            background: #4CAF50;
            color: white;
        }

        .status-inactive {
            background: #f44336;
            color: white;
        }

        .status-pending {
            background: #ff9800;
            color: white;
        }

        .status-suspended {
            background: #9e9e9e;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f5f5f5;
            padding: 12px;
        }

        /* ===== SORTABLE HEADERS ===== */
        th.sortable {
            position: relative;
            padding-right: 30px;
        }

        th.sortable a {
            display: block;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            padding: 5px 0;
        }

        th.sortable a:hover {
            color: #2196F3;
        }

        /* Sort arrow icons */
        .sort-icon {
            display: inline-block;
            margin-left: 8px;
            font-size: 12px;
            color: #999;
        }

        .sort-icon.active {
            color: #2196F3;
            font-weight: bold;
        }

        .sort-icon.asc::after {
            content: ' ▲';
        }

        .sort-icon.desc::after {
            content: ' ▼';
        }

        /* Highlight active sorted column */
        th.active-sort {
            background: #e3f2fd;
        }

        th.active-sort a {
            color: #1976D2;
        }

        /* Sorting indicator badge */
        .sort-badge {
            display: inline-block;
            background: #2196F3;
            color: white;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: 5px;
        }

        .pagination {
            margin-top: 20px;
        }

        .stats {
            margin-top: 10px;
            color: #666;
            font-size: 14px;
        }

        .active-filters {
            margin: 10px 0;
            padding: 10px 15px;
            background: #e3f2fd;
            border-radius: 4px;
            font-size: 14px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .active-filters .filter-tag {
            background: #2196F3;
            color: white;
            padding: 3px 12px;
            border-radius: 12px;
            display: inline-block;
            font-size: 13px;
        }

        .active-filters .filter-tag .remove {
            color: white;
            text-decoration: none;
            margin-left: 5px;
            font-weight: bold;
        }

        .active-filters .filter-tag .remove:hover {
            color: #ff4444;
        }

        /* Sort options dropdown for mobile */
        .sort-options {
            display: flex;
            gap: 10px;
            align-items: center;
            margin: 10px 0;
            padding: 10px 15px;
            background: #f9f9f9;
            border-radius: 4px;
            flex-wrap: wrap;
        }

        .sort-options label {
            font-weight: bold;
            margin-right: 5px;
        }

        .sort-options select,
        .sort-options button {
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .sort-options button {
            background: #2196F3;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>👥 User Management</h1>

    <!-- Filters Section -->
    <div class="filters">
        <form method="GET" action="{{ route('users.index') }}"
            style="display: flex; gap: 15px; flex-wrap: wrap; width: 100%;">
            <input type="text" name="search" placeholder="🔍 Search by name..." value="{{ request('search') }}">

            <select name="status">
                <option value="">📊 All Statuses</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>✅ Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>❌ Inactive</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>⛔ Suspended</option>
            </select>

            <button type="submit">Apply Filters</button>
            <a href="{{ route('users.index') }}" class="clear-btn">🔄 Clear All</a>
        </form>
    </div>

    <!-- Active Filters Display -->
    @if(request('search') || request('status') || request('sort_by'))
        <div class="active-filters">
            <strong>Active Filters:</strong>
            @if(request('search'))
                <span class="filter-tag">
                    🔍 {{ request('search') }}
                    <a href="{{ route('users.index', array_merge(request()->query(), ['search' => null])) }}"
                        class="remove">✕</a>
                </span>
            @endif
            @if(request('status'))
                <span class="filter-tag">
                    📊 {{ ucfirst(request('status')) }}
                    <a href="{{ route('users.index', array_merge(request()->query(), ['status' => null])) }}"
                        class="remove">✕</a>
                </span>
            @endif
            @if(request('sort_by'))
                <span class="filter-tag">
                    ↕ Sort: {{ ucfirst(request('sort_by')) }}
                    {{ strtoupper(request('direction', 'asc')) }}
                    <a href="{{ route('users.index', array_merge(request()->query(), ['sort_by' => null, 'direction' => null])) }}"
                        class="remove">✕</a>
                </span>
            @endif
        </div>
    @endif

    <!-- Stats -->
    <div class="stats">
        📈 Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }}
        of {{ $users->total() }} users
    </div>

    <!-- ===== SORT OPTIONS DROPDOWN (Alternative UI) ===== -->
    <div class="sort-options">
        <label for="sort_by">↕ Sort by:</label>
        <form method="GET" action="{{ route('users.index') }}"
            style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
            <!-- Preserve existing filters -->
            @foreach(request()->except(['sort_by', 'direction', 'page']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <select name="sort_by" id="sort_by">
                <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>ID</option>
                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date
                </option>
            </select>

            <select name="direction">
                <option value="asc" {{ request('direction', 'asc') == 'asc' ? 'selected' : '' }}>🔼 Ascending</option>
                <option value="desc" {{ request('direction', 'desc') == 'desc' ? 'selected' : '' }}>🔽 Descending</option>
            </select>

            <button type="submit">Apply Sort</button>
        </form>
    </div>

    <!-- Users Table with Clickable Sort Headers -->
    @if($users->count() > 0)
        <table>
            <thead>
                <tr>
                    <!-- ID Column -->
                    <th class="sortable {{ request('sort_by') == 'id' ? 'active-sort' : '' }}">
                        <a
                            href="{{ route('users.index', array_merge(request()->query(), ['sort_by' => 'id', 'direction' => request('sort_by') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                            ID
                            <span
                                class="sort-icon {{ request('sort_by') == 'id' ? 'active' : '' }} {{ request('direction', 'asc') }}">
                                @if(request('sort_by') == 'id')
                                    {{ request('direction', 'asc') == 'asc' ? '▲' : '▼' }}
                                @else
                                    ⇅
                                @endif
                            </span>
                            @if(request('sort_by') == 'id')
                                <span class="sort-badge">{{ strtoupper(request('direction', 'asc')) }}</span>
                            @endif
                        </a>
                    </th>

                    <!-- Name Column -->
                    <th class="sortable {{ request('sort_by') == 'name' ? 'active-sort' : '' }}">
                        <a
                            href="{{ route('users.index', array_merge(request()->query(), ['sort_by' => 'name', 'direction' => request('sort_by') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                            Name
                            <span
                                class="sort-icon {{ request('sort_by') == 'name' ? 'active' : '' }} {{ request('direction', 'asc') }}">
                                @if(request('sort_by') == 'name')
                                    {{ request('direction', 'asc') == 'asc' ? '▲' : '▼' }}
                                @else
                                    ⇅
                                @endif
                            </span>
                            @if(request('sort_by') == 'name')
                                <span class="sort-badge">{{ strtoupper(request('direction', 'asc')) }}</span>
                            @endif
                        </a>
                    </th>

                    <!-- Email Column -->
                    <th class="sortable {{ request('sort_by') == 'email' ? 'active-sort' : '' }}">
                        <a
                            href="{{ route('users.index', array_merge(request()->query(), ['sort_by' => 'email', 'direction' => request('sort_by') == 'email' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                            Email
                            <span
                                class="sort-icon {{ request('sort_by') == 'email' ? 'active' : '' }} {{ request('direction', 'asc') }}">
                                @if(request('sort_by') == 'email')
                                    {{ request('direction', 'asc') == 'asc' ? '▲' : '▼' }}
                                @else
                                    ⇅
                                @endif
                            </span>
                            @if(request('sort_by') == 'email')
                                <span class="sort-badge">{{ strtoupper(request('direction', 'asc')) }}</span>
                            @endif
                        </a>
                    </th>

                    <!-- Status Column -->
                    <th class="sortable {{ request('sort_by') == 'status' ? 'active-sort' : '' }}">
                        <a
                            href="{{ route('users.index', array_merge(request()->query(), ['sort_by' => 'status', 'direction' => request('sort_by') == 'status' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                            Status
                            <span
                                class="sort-icon {{ request('sort_by') == 'status' ? 'active' : '' }} {{ request('direction', 'asc') }}">
                                @if(request('sort_by') == 'status')
                                    {{ request('direction', 'asc') == 'asc' ? '▲' : '▼' }}
                                @else
                                    ⇅
                                @endif
                            </span>
                            @if(request('sort_by') == 'status')
                                <span class="sort-badge">{{ strtoupper(request('direction', 'asc')) }}</span>
                            @endif
                        </a>
                    </th>

                    <!-- Created At Column -->
                    <th class="sortable {{ request('sort_by') == 'created_at' ? 'active-sort' : '' }}">
                        <a
                            href="{{ route('users.index', array_merge(request()->query(), ['sort_by' => 'created_at', 'direction' => request('sort_by') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                            Created At
                            <span
                                class="sort-icon {{ request('sort_by') == 'created_at' ? 'active' : '' }} {{ request('direction', 'asc') }}">
                                @if(request('sort_by') == 'created_at')
                                    {{ request('direction', 'asc') == 'asc' ? '▲' : '▼' }}
                                @else
                                    ⇅
                                @endif
                            </span>
                            @if(request('sort_by') == 'created_at')
                                <span class="sort-badge">{{ strtoupper(request('direction', 'asc')) }}</span>
                            @endif
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="status-badge status-{{ $user->status }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $users->appends(request()->query())->links() }}
        </div>
    @else
        <div style="padding: 40px; text-align: center; color: #666;">
            <p>No users found matching your criteria</p>
        </div>
    @endif
</body>

</html>