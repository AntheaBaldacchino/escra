<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Dashboard</title>
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h1 class="h3 fw-bold mb-0">Writing Dashboard</h1>
      <div class="text-muted">Code: <span class="fw-semibold">{{ $user->user_code }}</span></div>
    </div>

    <form method="POST" action="{{ route('document.destroy', ['code' => $user->user_code]) }}"
          onsubmit="return confirm('Delete your document and all saved ideas? This cannot be undone.');">
      @csrf
      @method('DELETE')
      <button class="btn btn-outline-danger">Delete Workspace</button>
    </form>
  </div>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="card shadow border-0 rounded-4">
    <div class="card-body p-4">
      <form method="POST" action="{{ route('document.update', ['code' => $user->user_code]) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label fw-semibold">Your document</label>
          <textarea name="content" class="form-control" rows="14" placeholder="Start writing...">{{ old('content', $document->content) }}</textarea>
        </div>

        <div class="d-flex gap-2">
          <button class="btn btn-primary">Save</button>
          <a class="btn btn-secondary" href="{{ route('code.form') }}">Exit</a>
        </div>
      </form>
    </div>
  </div>

  <p class="text-muted small mt-3 mb-0">
    Next: add “Generate Idea” + Saved Ideas page.
  </p>
</div>
</body>
</html>
