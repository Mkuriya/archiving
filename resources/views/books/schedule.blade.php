<<<<<<< Updated upstream
@include('partials.adminnav')

<link rel="stylesheet" href="/css/calendar.css">
<div class="wrap bg-gray-800">
  <header>
    <div class="title-block text-white">
      <h1>Library Schedule</h1>
    </div>
    <div class="nav">
      <button id="prevBtn" aria-label="Previous month">&#8592;</button>
      <span class="month-label text-white" id="monthLabel"></span>
      <button id="nextBtn" aria-label="Next month">&#8594;</button>
    </div>
  </header>
=======

@include('partials.adminnav')

<link rel="stylesheet" href="/css/calendars.css">

<div class="cal-page" >
  <header>
    <h1>Library Schedule</h1>
    <div class="nav">
      <button id="prevBtn" aria-label="Previous month">&#8592;</button>
      <span class="month-label" id="monthLabel"></span>
      <button id="nextBtn" aria-label="Next month">&#8594;</button>
    </div>
  </header>

>>>>>>> Stashed changes
  <div class="layout">
    <div>
      <div class="cal-card">
        <table>
          <thead>
<<<<<<< Updated upstream
            <tr class="bg-blue-900 text-white">
              <th >S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th >S</th>
=======
            <tr>
              <th class="wknd">S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th class="wknd">S</th>
>>>>>>> Stashed changes
            </tr>
          </thead>
          <tbody id="calBody"></tbody>
        </table>
      </div>
<<<<<<< Updated upstream
    </div>

    <div class="side">
      <div class="panel" id="editorPanel">
=======

    </div>

    <div class="side">
      <div class="panel">
>>>>>>> Stashed changes
        <h2>Entry</h2>
        <div class="date-display" id="selDateLabel">Select a date</div>
        <textarea id="noteInput" placeholder="Notes" disabled></textarea>
        <div class="row">
          <button class="btn" id="saveBtn" disabled>Save</button>
<<<<<<< Updated upstream
          <button class="btn secondary" id="clearBtn" hidden disabled>Clear</button>
        </div>
        <div id="status"></div>
      </div>

      <div class="panel list">
        <h2 class="text-black">This month's entries</h2>
        <div class="entries text-black" id="entriesList"></div>
=======
          <button class="btn danger" id="clearBtn" disabled>Clear</button>
          <a class="btn secondary" href="/">Back</a>
        </div>
        <div id="status"></div>
        <div class="hint">Click any date.</div>
      </div>

      <div class="panel">
        <h2>This month's entries</h2>
        <div class="entries" id="entriesList"></div>
>>>>>>> Stashed changes
      </div>
    </div>
  </div>
</div>
<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
<script>
(function(){
  const monthLabelEl = document.getElementById('monthLabel');
  const calBody = document.getElementById('calBody');
  const noteInput = document.getElementById('noteInput');
  const selDateLabel = document.getElementById('selDateLabel');
  const saveBtn = document.getElementById('saveBtn');
  const clearBtn = document.getElementById('clearBtn');
  const statusEl = document.getElementById('status');
  const entriesList = document.getElementById('entriesList');

<<<<<<< Updated upstream
  const today = new Date();
  let viewYear = today.getFullYear();
  let viewMonth = today.getMonth();
  let selectedKey = null;let notesCache = {};

    const MONTH_NAMES = [
        "January","February","March","April","May","June",
        "July","August","September","October","November","December"
    ];

    function pad(n){
        return n < 10 ? "0" + n : "" + n;
    }

    function keyFor(y,m,d){
        return y + "-" + pad(m+1) + "-" + pad(d);
    }

    // LOAD NOTES FROM LOCAL STORAGE
    function loadMonthNotes(y,m){

        notesCache = {};

        const prefix = y + "-" + pad(m+1) + "-";

        for(let i = 0; i < localStorage.length; i++){

            const key = localStorage.key(i);

            if(key.startsWith(prefix)){
                notesCache[key] = localStorage.getItem(key);
            }
        }
    }

    function setStatus(msg){
        statusEl.textContent = msg;
        if(msg){
            setTimeout(()=>{
                if(statusEl.textContent === msg){
                    statusEl.textContent = "";
                }
            },2000);
        }
    }

    function escapeHtml(s){
        const div=document.createElement("div");
        div.textContent=s;
        return div.innerHTML;
    }

    function render(){

        monthLabelEl.textContent =
            MONTH_NAMES[viewMonth] + " " + viewYear;

        calBody.innerHTML="";
        entriesList.innerHTML="";

        const firstDow=new Date(viewYear,viewMonth,1).getDay();
        const daysInMonth=new Date(viewYear,viewMonth+1,0).getDate();

        let cells=[];

        for(let i=0;i<firstDow;i++) cells.push(null);

        for(let d=1;d<=daysInMonth;d++) cells.push(d);

        while(cells.length%7!==0) cells.push(null);

        let entryRows=[];

        for(let r=0;r<cells.length/7;r++){

            const tr=document.createElement("tr");

            for(let c=0;c<7;c++){
                const d=cells[r*7+c];
                const td=document.createElement("td");

                if(d===null){
                    td.className="empty";
                }else{

                    const isWeekend=(c===0||c===6);
                    const key=keyFor(viewYear,viewMonth,d);
                    const note=notesCache[key]||"";
                    let cls=isWeekend?"weekend":"";
                    if(note.trim()) cls+=" has-note";
                    if(key===selectedKey) cls+=" selected";
                    td.className=cls.trim();

                    const num=document.createElement("span");
                    num.className="num";
                    num.textContent=d;
                    td.appendChild(num);

                    if(note.trim()){
                        const tag=document.createElement("span");
                        tag.className="tag";
                        const firstLine=note.split("\n")[0];
                        tag.textContent=
                            firstLine.length>22
                            ? firstLine.slice(0,22)+"..."
                            : firstLine;

                        td.appendChild(tag);
                        entryRows.push({
                            key,
                            day:d,
                            note,
                            isWeekend
                        });
                    }
                    td.addEventListener("click",()=>selectDate(key));
                }
                tr.appendChild(td);

            }

            calBody.appendChild(tr);

        }

        if(entryRows.length===0){

            entriesList.innerHTML=
            '<div class="empty-note">No entries yet this month.</div>';

        }else{

            entryRows.sort((a,b)=>a.day-b.day);
            entryRows.forEach(e=>{
                const div=document.createElement("div");
                div.className="entry"+(e.isWeekend?" wknd":"");
                div.innerHTML=
                '<span class="d">'+
                MONTH_NAMES[viewMonth].slice(0,3)+" "+e.day+
                '</span><span class="note-text">'+
                escapeHtml(e.note)+
                "</span>";
                div.onclick=()=>selectDate(e.key);
                entriesList.appendChild(div);
            });

        }

        if(selectedKey){
            const d=parseInt(selectedKey.split("-")[2]);
            selDateLabel.textContent=
                MONTH_NAMES[viewMonth]+" "+d+", "+viewYear;
            noteInput.disabled=false;
            saveBtn.disabled=false;
            clearBtn.disabled=false;
            noteInput.value=notesCache[selectedKey]||"";
        }

    }

    function selectDate(key){
        selectedKey=key;
        render();
        noteInput.focus();
    }

    // SAVE NOTE
    saveBtn.addEventListener("click",()=>{

        if(!selectedKey) return;
        const text=noteInput.value.trim();
        if(text){
            localStorage.setItem(selectedKey,text);
            notesCache[selectedKey]=text;
            setStatus("Saved.");
        }else{
            localStorage.removeItem(selectedKey);
            delete notesCache[selectedKey];
            setStatus("Cleared.");
        }
        render();
    });

    // CLEAR NOTE
    clearBtn.addEventListener("click",()=>{
        if(!selectedKey) return;
        noteInput.value="";
        localStorage.removeItem(selectedKey);
        delete notesCache[selectedKey];
        setStatus("Cleared.");
        render();
    });

    // PREVIOUS MONTH
    document.getElementById("prevBtn").addEventListener("click",()=>{
        viewMonth--;
        if(viewMonth<0){
            viewMonth=11;
            viewYear--;
        }
        selectedKey=null;
        resetEditor();
        loadMonthNotes(viewYear,viewMonth);
        render();
    });

    // NEXT MONTH
    document.getElementById("nextBtn").addEventListener("click",()=>{
        viewMonth++;
        if(viewMonth>11){
            viewMonth=0;
            viewYear++;
        }
        selectedKey=null;
        resetEditor();
        loadMonthNotes(viewYear,viewMonth);
        render();

    });

    function resetEditor(){
        selDateLabel.textContent="Select a date";
        noteInput.value="";
        noteInput.disabled=true;
        saveBtn.disabled=true;
        clearBtn.disabled=true;
    }

    // INITIALIZE
    (function(){
        resetEditor();
        loadMonthNotes(viewYear,viewMonth);
        render();
    })();
})();
</script>
</body>
</html>
=======
  // ---- API config ----
  // Adjust these to match your actual Laravel routes.
 const API = {
    list: (y, m) => `/calendar/load?year=${y}&month=${m}`,
    save: () => `/calendar/save`,
    remove: () => `/calendar/delete`,
};

  // Laravel needs the CSRF token for POST/DELETE requests.
  // Make sure your blade layout has: <meta name="csrf-token" content="{{ csrf_token() }}">
  function csrfToken(){
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
  }

  const today = new Date();
  let viewYear = today.getFullYear();
  let viewMonth = today.getMonth();
  let selectedKey = null;
  let notesCache = {};
  let isLoading = false;

  const MONTH_NAMES = [
    "January","February","March","April","May","June",
    "July","August","September","October","November","December"
  ];

  function pad(n){
    return n < 10 ? "0" + n : "" + n;
  }

  function keyFor(y,m,d){
    return y + "-" + pad(m+1) + "-" + pad(d);
  }

  // ---- LOAD NOTES FROM DATABASE (was: localStorage) ----
  async function loadMonthNotes(y, m){
    isLoading = true;
    setStatus("Loading...");

    try {
      const res = await fetch(API.list(y, pad(m+1)), {
        headers: { 'Accept': 'application/json' }
      });

      if(!res.ok){
        throw new Error("Request failed: " + res.status);
      }

      notesCache = await res.json();
      setStatus("");
    } catch (err) {
      console.error(err);
      notesCache = {};
      setStatus("Failed to load notes.");
    } finally {
      isLoading = false;
    }
  }

  function setStatus(msg){
    statusEl.textContent = msg;

    if(msg){
      setTimeout(()=>{
        if(statusEl.textContent === msg){
          statusEl.textContent = "";
        }
      },2000);
    }
  }

  function escapeHtml(s){
    const div=document.createElement("div");
    div.textContent=s;
    return div.innerHTML;
  }

  function render(){

    monthLabelEl.textContent =
      MONTH_NAMES[viewMonth] + " " + viewYear;

    calBody.innerHTML="";
    entriesList.innerHTML="";

    const firstDow=new Date(viewYear,viewMonth,1).getDay();
    const daysInMonth=new Date(viewYear,viewMonth+1,0).getDate();

    let cells=[];

    for(let i=0;i<firstDow;i++) cells.push(null);
    for(let d=1;d<=daysInMonth;d++) cells.push(d);
    while(cells.length%7!==0) cells.push(null);

    let entryRows=[];

    for(let r=0;r<cells.length/7;r++){

      const tr=document.createElement("tr");

      for(let c=0;c<7;c++){

        const d=cells[r*7+c];
        const td=document.createElement("td");

        if(d===null){
          td.className="empty";
        }else{

          const isWeekend=(c===0||c===6);
          const key=keyFor(viewYear,viewMonth,d);
          const note=notesCache[key]||"";

          let cls=isWeekend?"weekend":"";
          if(note.trim()) cls+=" has-note";
          if(key===selectedKey) cls+=" selected";

          td.className=cls.trim();

          const num=document.createElement("span");
          num.className="num";
          num.textContent=d;
          td.appendChild(num);

          if(note.trim()){

            const tag=document.createElement("span");
            tag.className="tag";

            const firstLine=note.split("\n")[0];

            tag.textContent=
              firstLine.length>22
              ? firstLine.slice(0,22)+"..."
              : firstLine;

            td.appendChild(tag);

            entryRows.push({ key, day:d, note, isWeekend });
          }

          td.addEventListener("click",()=>selectDate(key));
        }

        tr.appendChild(td);
      }

      calBody.appendChild(tr);
    }

    if(entryRows.length===0){
      entriesList.innerHTML =
        '<div class="empty-note">No entries yet this month.</div>';
    }else{

      entryRows.sort((a,b)=>a.day-b.day);

      entryRows.forEach(e=>{
        const div=document.createElement("div");
        div.className="entry"+(e.isWeekend?" wknd":"");
        div.innerHTML=
          '<span class="d">'+
          MONTH_NAMES[viewMonth].slice(0,3)+" "+e.day+
          '</span><span class="note-text">'+
          escapeHtml(e.note)+
          "</span>";
        div.onclick=()=>selectDate(e.key);
        entriesList.appendChild(div);
      });
    }

    if(selectedKey){

      const d=parseInt(selectedKey.split("-")[2]);

      selDateLabel.textContent=
        MONTH_NAMES[viewMonth]+" "+d+", "+viewYear;

      noteInput.disabled=false;
      saveBtn.disabled=false;
      clearBtn.disabled=false;

      noteInput.value=notesCache[selectedKey]||"";
    }
  }

  function selectDate(key){
    selectedKey=key;
    render();
    noteInput.focus();
  }

  // ---- SAVE NOTE (was: localStorage.setItem) ----
  saveBtn.addEventListener("click", async ()=>{

    if(!selectedKey) return;

    const text=noteInput.value.trim();

    saveBtn.disabled = true;

    try {
      if(text){

        const res = await fetch(API.save(), {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
          },
          body: JSON.stringify({ date: selectedKey, note: text })
        });

        if(!res.ok) throw new Error("Save failed: " + res.status);

        notesCache[selectedKey]=text;
        setStatus("Saved.");

      }else{

        // empty text -> treat as delete
        const res = await fetch(API.remove(selectedKey), {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
          }
        });

        if(!res.ok) throw new Error("Delete failed: " + res.status);

        delete notesCache[selectedKey];
        setStatus("Cleared.");
      }

    } catch (err) {
      console.error(err);
      setStatus("Something went wrong saving.");
    } finally {
      saveBtn.disabled = false;
      render();
    }
  });

  // ---- CLEAR NOTE (was: localStorage.removeItem) ----
  clearBtn.addEventListener("click", async ()=>{

    if(!selectedKey) return;

    clearBtn.disabled = true;

    try {
      const res = await fetch(API.remove(), {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
        },
        body: JSON.stringify({
            date: selectedKey
        })
    });

      if(!res.ok) throw new Error("Delete failed: " + res.status);

      noteInput.value="";
      delete notesCache[selectedKey];
      setStatus("Cleared.");

    } catch (err) {
      console.error(err);
      setStatus("Something went wrong clearing.");
    } finally {
      clearBtn.disabled = false;
      render();
    }
  });

  // PREVIOUS MONTH
  document.getElementById("prevBtn").addEventListener("click", async ()=>{

    viewMonth--;
    if(viewMonth<0){
      viewMonth=11;
      viewYear--;
    }

    selectedKey=null;
    resetEditor();

    await loadMonthNotes(viewYear,viewMonth);
    render();
  });

  // NEXT MONTH
  document.getElementById("nextBtn").addEventListener("click", async ()=>{

    viewMonth++;
    if(viewMonth>11){
      viewMonth=0;
      viewYear++;
    }

    selectedKey=null;
    resetEditor();

    await loadMonthNotes(viewYear,viewMonth);
    render();
  });

  function resetEditor(){
    selDateLabel.textContent="Select a date";
    noteInput.value="";
    noteInput.disabled=true;
    saveBtn.disabled=true;
    clearBtn.disabled=true;
  }

  // INITIALIZE
  (async function(){
    resetEditor();
    await loadMonthNotes(viewYear,viewMonth);
    render();
  })();
})();
</script>
>>>>>>> Stashed changes
