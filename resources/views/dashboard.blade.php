<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Dashboard</title>

  <style>
    :root{
      --sidebar-w: 300px;
      --sidebar-bg: #7fb0b0;     /* teal sidebar */
      --page-bg: #e9e9e9;        /* light grey background */
      --ink: #2d2d2d;
      --muted: rgba(0,0,0,.55);

      --pill-bg: #2f4b50;        /* dark teal */
      --accent: #d6b55b;         /* gold-ish */
      --idea-border: #234b26;    /* green border */
    }

    body{
      background: var(--page-bg);
      color: var(--ink);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar{
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: var(--sidebar-w);
      background: var(--sidebar-bg);
      padding: 28px 22px;
      display: flex;
      flex-direction: column;
      gap: 26px;
    }

    .brand{
      display: grid;
      justify-items: center;
      gap: 10px;
      margin-top: 6px;
    }

    .logo-placeholder{
      width: 86px;
      height: 64px;
      border-radius: 14px;
      border: 2px solid rgba(0,0,0,.25);
      background: rgba(255,255,255,.18);
      display: grid;
      place-items: center;
      font-weight: 700;
      letter-spacing: .04em;
      color: rgba(0,0,0,.55);
      font-size: 12px;
    }

    .brand-name{
      font-weight: 700;
      letter-spacing: .02em;
      color: rgba(0,0,0,.65);
      margin: 0;
      font-size: 20px;
    }

    .meta{
      margin-top: 26px;
      padding-left: 10px;
      color: rgba(0,0,0,.6);
      font-size: 22px;
      line-height: 2.2;
    }

    .sidebar-actions{
      margin-top: auto;
      display: grid;
      gap: 12px;
      padding-left: 10px;
      padding-bottom: 10px;
    }

    .btn-pill{
      background: var(--pill-bg);
      color: rgba(255,255,255,.95);
      border: 0;
      border-radius: 999px;
      padding: 14px 22px;
      width: 210px;
      box-shadow: 0 12px 22px rgba(0,0,0,.18);
      font-weight: 600;
      text-align: center;
    }

    .btn-pill:hover{ filter: brightness(1.03); }

    .main{
      margin-left: var(--sidebar-w);
      padding: 70px 60px 120px;
      max-width: 1100px;
    }

    .chapter-title{
      font-size: 30px;
      width: 500px;
      font-weight: 700;
      margin-bottom: 8px;
      box-shadow: none; 
    }

    .chapter-subtitle{
      font-style: italic;
      color: rgba(0,0,0,.55);
      margin-bottom: 26px;
      font-size: 18px;
      box-shadow: none; 
    }

    .doc-textarea{
      width: 100%;
      min-height: 380px;
      border: 0;
      background: transparent;
      resize: vertical;
      font-size: 20px;
      line-height: 1.6;
      color: rgba(0,0,0,.72);
      outline: none;
    }

    .doc-textarea::placeholder{
      color: rgba(0,0,0,.35);
    }

    .top-actions{
      display: flex;
      gap: 10px;
      align-items: center;
      margin-top: 18px;
    }

    .back-tab{
      position: fixed;
      top: 18px;
      left: calc(var(--sidebar-w) - 26px);
      width: 52px;
      height: 46px;
      border-radius: 12px;
      background: rgba(127,176,176,.9);
      display: grid;
      place-items: center;
      box-shadow: 0 10px 18px rgba(0,0,0,.18);
      z-index: 50;
    }

    .back-tab a{
      text-decoration: none;
      color: rgba(0,0,0,.65);
      font-weight: 900;
      font-size: 18px;
      line-height: 1;
    }

    .idea-float{
      position: fixed;
      right: 72px;
      bottom: 48px;
      width: min(560px, calc(100vw - var(--sidebar-w) - 120px));
      background: rgba(230,230,230,.92);
      border: 3px solid var(--idea-border);
      border-radius: 18px;
      box-shadow: 0 18px 30px rgba(0,0,0,.22);
      z-index: 40;
    }

    .idea-float .idea-body{
      padding: 18px 18px 64px;
    }

    .idea-label{
      font-weight: 700;
      color: rgba(0,0,0,.7);
      margin-bottom: 8px;
    }

    .idea-textarea{
      width: 100%;
      border: 0;
      background: transparent;
      outline: none;
      resize: none;
      font-size: 20px;
      line-height: 1.4;
      color: rgba(0,0,0,.65);
      min-height: 70px;
    }

    .idea-actions{
      position: absolute;
      left: 50%;
      bottom: -18px;
      transform: translateX(-50%);
      display: flex;
      border-radius: 999px;
      overflow: hidden;
      box-shadow: 0 14px 24px rgba(0,0,0,.22);
    }

    .idea-actions button{
      border: 0;
      padding: 12px 34px;
      background: var(--pill-bg);
      color: rgba(255,255,255,.92);
      font-weight: 600;
      font-size: 18px;
      min-width: 140px;
    }

    .idea-actions button + button{
      border-left: 2px solid rgba(214,181,91,.65);
      color: var(--accent);
    }

    .fab{
      position: fixed;
      right: 24px;
      bottom: 22px;
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: var(--accent);
      border: 3px solid rgba(0,0,0,.55);
      box-shadow: 0 14px 24px rgba(0,0,0,.25);
      display: grid;
      place-items: center;
      z-index: 60;
      cursor: pointer;
      user-select: none;
      font-weight: 900;
      color: rgba(0,0,0,.65);
    }
    .chapter-title[contenteditable="true"] {
        outline: none;
        cursor: text;
    }

    .chapter-title[contenteditable="true"]:empty:before {
        content: attr(data-placeholder);
        color: rgba(0,0,0,.4);
    }


    @media (max-width: 992px){
      .sidebar{ position: static; width: 100%; height: auto; }
      .main{ margin-left: 0; padding: 28px 18px 140px; }
      .back-tab{ display:none; }
      .idea-float{
        width: calc(100vw - 36px);
        right: 18px;
      }
    }
  </style>
</head>

<body>

  {{-- Exit --}}
  <div class="back-tab">
    <a href="{{ route('code.form') }}" title="Back">&larr;</a>
  </div>

  {{-- Sidebar --}}
  <aside class="sidebar">
    <div class="brand">
      <div class="logo-placeholder">LOGO</div>
      <p class="brand-name mb-0">Escra</p>
    </div>

    <div class="meta">
        <div>User Code:</div>
        <div class="fw-bold">{{ $user->user_code }}</div>
        
        <div>Created</div>
         <div>{{ optional($document->created_at)->timezone('Europe/Malta')->format('d M Y') }}
         </div>
    </div>

    <div class="sidebar-actions">
      <a class="btn-pill text-decoration-none"
         href="{{ route('ideas.index', ['code' => $user->user_code]) }}">
        Saved Ideas
      </a>

      <form method="POST"
            action="{{ route('document.destroy', ['code' => $user->user_code]) }}"
            onsubmit="return confirm('Delete your document and all saved ideas? This cannot be undone.');">
        @csrf
        @method('DELETE')
        <button class="btn-pill" type="submit" style="background: rgba(0,0,0,.35);">
          Delete Workspace
        </button>
      </form>
    </div>
  </aside>

  {{-- Main --}}
  <main class="main">

    @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    
    <form method="POST" action="{{ route('document.update', ['code' => $user->user_code]) }}">
      @csrf
      @method('PUT')

        <div class="row g-2 mb-3">
            <div class="col-md-4">

                <input
                type="text"
                id="chapterTitle"
                name="chapter"
                class="form-control form-control-lg border-0 bg-transparent chapter-title"
                placeholder="Chapter"
                value="{{ old('chapter', $document->chapter ?? '') }}">
            </div>
        </div>

         <div class="col-md-8">
                
                <input
                    type="text"
                    name="subtitle"
                    class="form-control border-0 bg-transparent chapter-subtitle"
                    value="{{ old('subtitle', $document->subtitle ?? '') }}"
                    placeholder="Subtitle"
                >
         </div>

      <textarea  name="content" class="doc-textarea"  placeholder="Start writing...">{{ old('content', $document->content) }}</textarea>


      <div class="top-actions">
        <button class="btn btn-dark px-4" type="submit">Save</button>
        <a class="btn btn-outline-dark px-4" href="{{ route('code.form') }}">Exit</a>
      </div>
    </form>
  </main>

  {{-- Floating Idea Card --}}
  <div id="ideaCard" class="idea-float d-none">
    <div class="idea-body">
      <div class="idea-label">Idea: <span id="ideaIndex">1</span></div>

      <form id="ideaForm" method="POST" action="{{ route('ideas.store', ['code' => $user->user_code]) }}">
        @csrf
        <textarea id="ideaText" name="idea_text" class="idea-textarea" required></textarea>

        <div class="idea-actions">
          <button type="submit">Save</button>
          <button id="skipIdeaBtn" type="button">Skip</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Floating action button placeholder --}}
  <div class="fab" id="fabBtn" title="Ideas">✿</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const fabBtn = document.getElementById('fabBtn');
  const ideaCard = document.getElementById('ideaCard');
  const ideaText = document.getElementById('ideaText');
  const skipBtn = document.getElementById('skipIdeaBtn');

  let isGenerating = false;

  async function generateIdea() {
    if (isGenerating) return;
    isGenerating = true;

    fabBtn.style.opacity = '0.6';
    fabBtn.textContent = '…';

    try {
      const res = await fetch("{{ route('ideas.generate', ['code' => $user->user_code]) }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": "{{ csrf_token() }}",
          "Accept": "application/json",
        },
        body: JSON.stringify({})
      });

      const data = await res.json();

      if (!res.ok) {
        alert(data.error || "Failed to generate idea.");
        return;
      }

      ideaText.value = data.idea;
      ideaCard.classList.remove('d-none');
      ideaText.focus();

    } catch (e) {
      alert("Network error while generating idea.");
    } finally {
      isGenerating = false;
      fabBtn.style.opacity = '1';
      fabBtn.textContent = '✿';
    }
  }

  fabBtn.addEventListener('click', generateIdea);

  skipBtn.addEventListener('click', () => {
    ideaText.value = '';
    ideaCard.classList.add('d-none');
  });
});
</script>



</body>
</html>
