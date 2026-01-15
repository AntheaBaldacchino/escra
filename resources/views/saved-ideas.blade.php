<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Saved Ideas</title>
</head>

<body class="bg-light">
<div class="container py-4">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h1 class="h3 fw-bold mb-0">💡 Saved Ideas</h1>
      <div class="text-muted">Code: <span class="fw-semibold">{{ $user->user_code }}</span></div>
    </div>

    <a href="{{ route('dashboard', ['code' => $user->user_code]) }}" class="btn btn-primary">
      Back to Dashboard
    </a>
  </div>

  <!-- Alerts -->
  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif
  <div class="card border-0 shadow-sm rounded-4 mb-3">
  <div class="card-body p-3">
    <form method="GET" action="{{ route('ideas.index', ['code' => $user->user_code]) }}" class="row g-2 align-items-end">
      <div class="col-md-6">
        <label class="form-label fw-semibold mb-1">Search ideas</label>
        <input
          type="text"
          name="q"
          class="form-control"
          placeholder="Type a keyword..."
          value="{{ $q ?? request('q') }}"
        >
      </div>

        <div class="col-md-4">
          <label class="form-label fw-semibold mb-1">Sort by</label>
          <select name="sort" class="form-select">
            <option value="newest" {{ ($sort ?? request('sort')) === 'newest' ? 'selected' : '' }}>Newest first</option>
            <option value="oldest" {{ ($sort ?? request('sort')) === 'oldest' ? 'selected' : '' }}>Oldest first</option>
            <option value="az"     {{ ($sort ?? request('sort')) === 'az' ? 'selected' : '' }}>A → Z</option>
            <option value="za"     {{ ($sort ?? request('sort')) === 'za' ? 'selected' : '' }}>Z → A</option>
          </select>
        </div>

        <div class="col-md-2 d-grid">
          <button class="btn btn-primary">Apply</button>
        </div>

        <div class="col-12">
          <a class="btn btn-link p-0 text-decoration-none"
            href="{{ route('ideas.index', ['code' => $user->user_code]) }}">
            Reset
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Empty state -->
  @if($ideas->count() === 0)
    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body p-4 text-center">
        <p class="mb-1 fs-5">No saved ideas yet.</p>
        <p class="text-muted mb-0">Go back to the dashboard, generate ideas, then save the good ones.</p>
      </div>
    </div>
  @else
    <!-- Ideas grid -->
    <div class="row g-3">
      @foreach($ideas as $idea)
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <h5 class="card-title fw-bold mb-0">Idea</h5>
                <small class="text-muted">{{ $idea->created_at->format('Y-m-d') }}</small>
              </div>

              <p class="text-muted flex-grow-1 idea-text" id="idea-text-{{ $idea->id }}">
                {{ $idea->idea_text }}
              </p>

              <div class="d-flex gap-2 mt-2">
                <!-- Copy -->
                <button type="button"
                        class="btn btn-info btn-sm text-white"
                        onclick="copyIdea({{ $idea->id }})">
                  Copy
                </button>

                <!-- Toggle Edit -->
                <button class="btn btn-warning btn-sm text-white"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#editForm{{ $idea->id }}">
                  Edit
                </button>

                <!-- Delete -->
                <form method="POST"
                      action="{{ route('ideas.destroy', ['code' => $user->user_code, 'idea' => $idea->id]) }}"
                      onsubmit="return confirm('Delete this idea?');"
                      class="ms-auto">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm">Delete</button>
                </form>
              </div>

              <!-- Edit form (collapsed) -->
              <div class="collapse mt-3" id="editForm{{ $idea->id }}">
                <form method="POST" action="{{ route('ideas.update', ['code' => $user->user_code, 'idea' => $idea->id]) }}">
                  @csrf
                  @method('PUT')

                  <div class="mb-2">
                    <textarea class="form-control" name="idea_text" rows="3" required>{{ $idea->idea_text }}</textarea>
                  </div>

                  <button class="btn btn-success btn-sm">Save changes</button>
                </form>
              </div>

            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  async function copyIdea(id) {
    const el = document.getElementById(`idea-text-${id}`);
    const text = el ? el.innerText.trim() : '';

    if (!text) return;

    try {
      await navigator.clipboard.writeText(text);
      alert('Copied!');
    } catch (e) {
      const ta = document.createElement('textarea');
      ta.value = text;
      document.body.appendChild(ta);
      ta.select();
      document.execCommand('copy');
      document.body.removeChild(ta);
      alert('Copied!');
    }
  }
</script>

</body>
</html>
