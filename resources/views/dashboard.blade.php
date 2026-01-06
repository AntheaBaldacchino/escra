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

    <div class="d-flex gap-2 mt-3">
  <button id="generateIdeaBtn" type="button" class="btn btn-success">
    Generate Idea
  </button>

  <a class="btn btn-secondary" href="{{ route('ideas.index', ['code' => $user->user_code]) }}">
    Saved Ideas
  </a>
</div>

<div id="ideaCard" class="card shadow border-0 rounded-4 mt-3 d-none">
  <div class="card-body p-4">
    <div class="d-flex justify-content-between align-items-start">
      <div>
        <h5 class="fw-bold mb-1">Generated Idea</h5>
        <p class="text-muted mb-3">Edit it if you want, then save it.</p>
      </div>
      <button id="skipIdeaBtn" type="button" class="btn btn-outline-secondary btn-sm">
        Skip
      </button>
    </div>

    <form method="POST" action="{{ route('ideas.store', ['code' => $user->user_code]) }}">
      @csrf
      <div class="mb-3">
        <textarea id="ideaText" name="idea_text" class="form-control" rows="3" required></textarea>
      </div>

      <button class="btn btn-primary">Save Idea</button>
    </form>
  </div>
</div>

</div>
<script>
  const ideas = [
    "Introduce a character who knows the ending from page one.",
    "Add a small contradiction in the protagonist’s memory that becomes important later.",
    "Reveal the real villain through an ordinary object that keeps appearing.",
    "A side character forces the main character to break their own rules.",
    "The setting changes in subtle ways every chapter, and nobody notices."
  ];

  const generateBtn = document.getElementById('generateIdeaBtn');
  const ideaCard = document.getElementById('ideaCard');
  const ideaText = document.getElementById('ideaText');
  const skipBtn = document.getElementById('skipIdeaBtn');

  generateBtn.addEventListener('click', () => {
    const randomIdea = ideas[Math.floor(Math.random() * ideas.length)];
    ideaText.value = randomIdea;
    ideaCard.classList.remove('d-none');
    ideaText.focus();
  });

  skipBtn.addEventListener('click', () => {
    ideaText.value = '';
    ideaCard.classList.add('d-none');
  });
</script>


</body>

</html>
