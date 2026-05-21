// ── Estado em memória ────────────────────────────────────────────────────────
const LOTES   = [];
const OVELHAS = [];
let loteAtivo = null;

// Estado dos filtros ativos na seção de ovelhas
const filtros = { sexo: "todos", raca: "todas", corBrinco: "todas", prenha: "todas" };

// Paleta de cores de brinco disponíveis
const CORES_BRINCO = [
  { valor: "amarelo",  label: "Amarelo",  hex: "#f5c518" },
  { valor: "azul",     label: "Azul",     hex: "#3b82f6" },
  { valor: "branco",   label: "Branco",   hex: "#e5e7eb" },
  { valor: "laranja",  label: "Laranja",  hex: "#f97316" },
  { valor: "rosa",     label: "Rosa",     hex: "#ec4899" },
  { valor: "roxo",     label: "Roxo",     hex: "#a855f7" },
  { valor: "verde",    label: "Verde",    hex: "#22c55e" },
  { valor: "vermelho", label: "Vermelho", hex: "#ef4444" },
];

function corBrincoInfo(valor) {
  return CORES_BRINCO.find(c => c.valor === valor) ?? null;
}

// ── Helpers ──────────────────────────────────────────────────────────────────
const fmtDate = (iso) => {
  if (!iso) return "—";
  const [y, m, d] = iso.split("-");
  return `${d}/${m}/${y}`;
};

function criarBtn(texto, cls) {
  const b = document.createElement("button");
  b.type = "button";
  b.className = `btn ${cls}`;
  b.textContent = texto;
  return b;
}

// ── Motor de modal ───────────────────────────────────────────────────────────
function criarModal({ titulo, corpo, rodape, onClose }) {
  const overlay = document.createElement("div");
  overlay.className = "modal-overlay";
  overlay.innerHTML = `
    <div class="modal-card" role="dialog" aria-modal="true">
      <header class="modal__head">
        <h3>${titulo}</h3>
        <button class="iconbtn modal-fechar" aria-label="Fechar">✕</button>
      </header>
      <div class="modal__body"></div>
      <footer class="modal__foot"></footer>
    </div>
  `;

  overlay.querySelector(".modal__body").appendChild(corpo);
  overlay.querySelector(".modal__foot").appendChild(rodape);

  function fechar() {
    if (onClose) onClose();
    overlay.remove();
    document.body.style.overflow = "";
    document.removeEventListener("keydown", onEsc);
  }

  function onEsc(e) { if (e.key === "Escape") fechar(); }

  overlay.addEventListener("click", (e) => { if (e.target === overlay) fechar(); });
  overlay.querySelector(".modal-fechar").addEventListener("click", fechar);
  document.addEventListener("keydown", onEsc);

  document.body.appendChild(overlay);
  document.body.style.overflow = "hidden";
  return fechar;
}

// ── Modal: Criar lote ────────────────────────────────────────────────────────
function abrirModalCriarLote() {
  const corpo = document.createElement("div");
  corpo.innerHTML = `
    <label class="field">
      <span>Nome do Lote</span>
      <input id="inputNomeLote" required placeholder="Ex.: Lote A — Matrizes" />
    </label>
  `;

  const rodape = document.createElement("div");
  rodape.style.display = "contents";
  const btnCancelar = criarBtn("Cancelar", "btn--ghost");
  const btnSalvar   = criarBtn("Criar Lote", "btn--primary");
  rodape.append(btnCancelar, btnSalvar);

  const fechar = criarModal({ titulo: "Criar novo lote", corpo, rodape });

  btnCancelar.addEventListener("click", fechar);
  btnSalvar.addEventListener("click", () => {
    const input = document.getElementById("inputNomeLote");
    const nome  = input.value.trim();
    if (!nome) { input.reportValidity(); return; }
    LOTES.push({ id: Date.now(), nome, icone: "🐑" });
    fechar();
    renderLotes();
  });
}

// ── Modal: Adicionar ovelha ──────────────────────────────────────────────────
function abrirModalAddOvelha() {
  if (LOTES.length === 0) {
    alert("Crie pelo menos um lote antes de adicionar ovelhas!");
    return;
  }

  const opcoesLote = LOTES
    .map((l) => `<option value="${l.id}"${l.id === loteAtivo ? " selected" : ""}>${l.nome}</option>`)
    .join("");

  const opcoesPai = `<option value="">— Não identificado —</option>` +
    OVELHAS.filter(o => o.sexo === "Macho")
      .map(o => `<option value="${o.id}">#${o.codigo} (${o.raca})</option>`).join("");

  const opcoesMae = `<option value="">— Não identificada —</option>` +
    OVELHAS.filter(o => o.sexo === "Fêmea")
      .map(o => `<option value="${o.id}">#${o.codigo} (${o.raca})</option>`).join("");

  // Opções de cor do brinco como botões visuais
  const opcoesCor = CORES_BRINCO.map(c => `
    <label class="cor-brinco-opcao">
      <input type="radio" name="corBrinco" value="${c.valor}" />
      <span class="cor-brinco-opcao__bolinha" style="background:${c.hex}" title="${c.label}"></span>
      <span class="cor-brinco-opcao__label">${c.label}</span>
    </label>
  `).join("");

  const corpo = document.createElement("div");
  corpo.innerHTML = `
    <div class="form__grid">
      <label class="field">
        <span>Brinco / Código</span>
        <input id="addCodigo" required placeholder="Ex.: 0125" />
      </label>
      <label class="field">
        <span>Cor do brinco</span>
        <div class="cor-brinco-picker" id="corBrincoPicker">
          ${opcoesCor}
        </div>
      </label>
    </div>
    <div class="form__grid">
      <label class="field">
        <span>Raça</span>
        <input id="addRaca" placeholder="Ex.: Texel" />
      </label>
      <label class="field">
        <span>Sexo</span>
        <select id="addSexo">
          <option value="Fêmea">Fêmea</option>
          <option value="Macho">Macho</option>
        </select>
      </label>
    </div>
    <div class="form__grid">
      <label class="field">
        <span>Nascimento</span>
        <input id="addNascimento" type="date" />
      </label>
      <label class="field">
        <span>Lote</span>
        <select id="addLote" required>${opcoesLote}</select>
      </label>
    </div>
    <div class="form__divider">Rastreamento genético <span class="badge--opcional">opcional</span></div>
    <div class="form__grid">
      <label class="field">
        <span>🐏 Pai</span>
        <select id="addPai">${opcoesPai}</select>
      </label>
      <label class="field">
        <span>🐑 Mãe</span>
        <select id="addMae">${opcoesMae}</select>
      </label>
    </div>
  `;

  const rodape = document.createElement("div");
  rodape.style.display = "contents";
  const btnCancelar = criarBtn("Cancelar", "btn--ghost");
  const btnSalvar   = criarBtn("Salvar", "btn--primary");
  rodape.append(btnCancelar, btnSalvar);

  const fechar = criarModal({ titulo: "Adicionar ovelha", corpo, rodape });

  btnCancelar.addEventListener("click", fechar);
  btnSalvar.addEventListener("click", () => {
    const codigo = document.getElementById("addCodigo").value.trim();
    const loteId = +document.getElementById("addLote").value;
    if (!codigo) { document.getElementById("addCodigo").reportValidity(); return; }
    if (!loteId) return;

    const corSelecionada = corpo.querySelector('input[name="corBrinco"]:checked')?.value ?? null;

    OVELHAS.push({
      id:         Date.now(),
      codigo,
      corBrinco:  corSelecionada,
      raca:       document.getElementById("addRaca").value.trim() || "—",
      sexo:       document.getElementById("addSexo").value,
      nascimento: document.getElementById("addNascimento").value,
      lote:       loteId,
      paiId:      document.getElementById("addPai").value   ? +document.getElementById("addPai").value   : null,
      maeId:      document.getElementById("addMae").value   ? +document.getElementById("addMae").value   : null,
      prenha:     false,
    });

    fechar();
    renderLotes();
    abrirLote(loteId);
  });
}

// ── Modal: Detalhes da ovelha ────────────────────────────────────────────────
function abrirModalDetalhes(ovelhaId) {
  const o = OVELHAS.find((x) => x.id === ovelhaId);
  if (!o) return;

  const nomeDoLote = LOTES.find((l) => l.id === o.lote)?.nome ?? "—";
  const nomePai    = o.paiId ? (OVELHAS.find(x => x.id === o.paiId)?.codigo ?? "—") : null;
  const nomeMae    = o.maeId ? (OVELHAS.find(x => x.id === o.maeId)?.codigo ?? "—") : null;
  const cor        = corBrincoInfo(o.corBrinco);

  const blocoGenético = `
    <dt>🐏 Pai</dt><dd>${nomePai ? `#${nomePai}` : '<span class="muted">Não identificado</span>'}</dd>
    <dt>🐑 Mãe</dt><dd>${nomeMae ? `#${nomeMae}` : '<span class="muted">Não identificada</span>'}</dd>
  `;

  const blocoCor = cor
    ? `<dt>Cor do brinco</dt><dd class="cor-detalhe"><span class="cor-dot" style="background:${cor.hex}"></span>${cor.label}</dd>`
    : `<dt>Cor do brinco</dt><dd><span class="muted">Não informada</span></dd>`;

  const blocoPrenha = o.sexo === "Fêmea" ? `
    <div class="prenha-toggle">
      <span>🤰 Situação reprodutiva</span>
      <label class="toggle">
        <input type="checkbox" id="checkPrenha" ${o.prenha ? "checked" : ""} />
        <span class="toggle__track"></span>
        <span class="toggle__label">${o.prenha ? "Prenha" : "Não prenha"}</span>
      </label>
    </div>
  ` : "";

  const corpo = document.createElement("div");
  corpo.innerHTML = `
    <dl class="dl">
      <dt>Código / Brinco</dt><dd>#${o.codigo}${o.prenha ? ' <span class="badge--prenha">🤰 Prenha</span>' : ""}</dd>
      ${blocoCor}
      <dt>Raça</dt><dd>${o.raca}</dd>
      <dt>Sexo</dt><dd>${o.sexo}</dd>
      <dt>Nascimento</dt><dd>${fmtDate(o.nascimento)}</dd>
      <dt>Lote</dt><dd>${nomeDoLote}</dd>
      ${blocoGenético}
    </dl>
    ${blocoPrenha}
  `;

  if (o.sexo === "Fêmea") {
    setTimeout(() => {
      const chk = document.getElementById("checkPrenha");
      const lbl = chk?.nextElementSibling?.nextElementSibling;
      if (!chk) return;
      chk.addEventListener("change", () => {
        o.prenha = chk.checked;
        if (lbl) lbl.textContent = o.prenha ? "Prenha" : "Não prenha";
        renderLotes();
        if (loteAtivo) abrirLote(loteAtivo);
      });
    }, 0);
  }

  const rodape = document.createElement("div");
  rodape.style.display = "contents";
  const btnRemover   = criarBtn("Remover", "btn--danger");
  const btnHistorico = criarBtn("📋 Histórico", "btn--outline");
  const btnFechar    = criarBtn("Fechar", "btn--ghost");
  rodape.append(btnRemover, btnHistorico, btnFechar);

  const fechar = criarModal({ titulo: `Ovelha #${o.codigo}`, corpo, rodape });

  btnFechar.addEventListener("click", fechar);

  btnHistorico.addEventListener("click", () => {
    sessionStorage.setItem("oviHistoricoId", o.id);
    sessionStorage.setItem("oviOvelhas",     JSON.stringify(OVELHAS));
    sessionStorage.setItem("oviLotes",       JSON.stringify(LOTES));
    window.location.href = "historico-veterinario.html";
  });

  btnRemover.addEventListener("click", () => {
    if (!confirm(`Remover a ovelha #${o.codigo}?`)) return;
    const idx = OVELHAS.findIndex((x) => x.id === ovelhaId);
    if (idx >= 0) OVELHAS.splice(idx, 1);
    fechar();
    renderLotes();
    if (loteAtivo) abrirLote(loteAtivo);
  });
}

// ── Renderização de lotes ────────────────────────────────────────────────────
function renderLotes() {
  const wrap = document.getElementById("lotes");

  if (LOTES.length === 0) {
    wrap.innerHTML = `
      <div class="empty-state">
        <h3>Nenhum lote encontrado</h3>
        <p class="muted">Crie seu primeiro lote para começar a gerenciar o rebanho.</p>
        <button class="btn btn--primary" id="btnCriarPrimeiroLote">+ Criar Primeiro Lote</button>
      </div>
    `;
    document.getElementById("btnCriarPrimeiroLote").addEventListener("click", abrirModalCriarLote);
    return;
  }

  wrap.innerHTML = LOTES.map((l) => {
    const lista   = OVELHAS.filter((o) => o.lote === l.id);
    const total   = lista.length;
    const prenhas = lista.filter(o => o.prenha).length;
    const badgePrenha = prenhas > 0
      ? `<span class="lote-card__prenha">🤰 ${prenhas} prenha${prenhas > 1 ? "s" : ""}</span>`
      : "";
    return `
      <button class="lote-card" data-lote="${l.id}">
        <div class="lote-card__head">
          <div class="lote-card__icon">${l.icone}</div>
          <div>
            <div class="lote-card__name">${l.nome}</div>
            <div class="lote-card__meta">${total} ovelha${total === 1 ? "" : "s"} ${badgePrenha}</div>
          </div>
        </div>
      </button>
    `;
  }).join("");

  wrap.querySelectorAll(".lote-card").forEach((el) =>
    el.addEventListener("click", () => abrirLote(+el.dataset.lote))
  );
}

// ── Filtros ──────────────────────────────────────────────────────────────────
function renderFiltros(listaDoLote) {
  const bar = document.getElementById("filtrosBar");

  // Valores únicos presentes neste lote
  const racas = [...new Set(listaDoLote.map(o => o.raca).filter(r => r && r !== "—"))];
  const cores = [...new Set(listaDoLote.map(o => o.corBrinco).filter(Boolean))];

  // Sem ovelhas = sem filtros
  if (listaDoLote.length === 0) { bar.innerHTML = ""; return; }

  const selectSexo = `
    <label class="filtro-campo">
      <span>Sexo</span>
      <select id="filtroSexo">
        <option value="todos">Todos</option>
        <option value="Fêmea"  ${filtros.sexo === "Fêmea"  ? "selected" : ""}>Fêmea</option>
        <option value="Macho"  ${filtros.sexo === "Macho"  ? "selected" : ""}>Macho</option>
      </select>
    </label>
  `;

  const selectRaca = racas.length > 1 ? `
    <label class="filtro-campo">
      <span>Raça</span>
      <select id="filtroRaca">
        <option value="todas">Todas</option>
        ${racas.map(r => `<option value="${r}" ${filtros.raca === r ? "selected" : ""}>${r}</option>`).join("")}
      </select>
    </label>
  ` : "";

  const selectCor = cores.length > 0 ? `
    <label class="filtro-campo">
      <span>Cor do brinco</span>
      <select id="filtroCor">
        <option value="todas">Todas</option>
        ${cores.map(c => {
          const info = corBrincoInfo(c);
          return `<option value="${c}" ${filtros.corBrinco === c ? "selected" : ""}>${info?.label ?? c}</option>`;
        }).join("")}
      </select>
    </label>
  ` : "";

  const temFemea = listaDoLote.some(o => o.sexo === "Fêmea");
  const selectPrenha = temFemea ? `
    <label class="filtro-campo">
      <span>Situação</span>
      <select id="filtroPrenha">
        <option value="todas">Todas</option>
        <option value="prenha"    ${filtros.prenha === "prenha"    ? "selected" : ""}>🤰 Prenhes</option>
        <option value="naoprenha" ${filtros.prenha === "naoprenha" ? "selected" : ""}>Não prenhes</option>
      </select>
    </label>
  ` : "";

  const totalFiltrado = aplicarFiltros(listaDoLote).length;
  const mostrandoBadge = totalFiltrado !== listaDoLote.length
    ? `<span class="filtro-resultado">${totalFiltrado} de ${listaDoLote.length}</span>`
    : "";

  const filtroAtivo = filtros.sexo !== "todos" || filtros.raca !== "todas" || filtros.corBrinco !== "todas" || filtros.prenha !== "todas";
  const btnLimpar = filtroAtivo
    ? `<button class="btn btn--ghost btn--sm" id="btnLimparFiltros">✕ Limpar filtros</button>`
    : "";

  bar.innerHTML = `
    <div class="filtros-inner">
      <span class="filtros-titulo">Filtrar por</span>
      ${selectSexo}
      ${selectRaca}
      ${selectCor}
      ${selectPrenha}
      ${mostrandoBadge}
      ${btnLimpar}
    </div>
  `;

  // Listeners
  document.getElementById("filtroSexo")?.addEventListener("change", (e) => {
    filtros.sexo = e.target.value;
    renderOvelhas(listaDoLote);
  });
  document.getElementById("filtroRaca")?.addEventListener("change", (e) => {
    filtros.raca = e.target.value;
    renderOvelhas(listaDoLote);
  });
  document.getElementById("filtroCor")?.addEventListener("change", (e) => {
    filtros.corBrinco = e.target.value;
    renderOvelhas(listaDoLote);
  });
  document.getElementById("filtroPrenha")?.addEventListener("change", (e) => {
    filtros.prenha = e.target.value;
    renderOvelhas(listaDoLote);
  });
  document.getElementById("btnLimparFiltros")?.addEventListener("click", () => {
    filtros.sexo = "todos";
    filtros.raca = "todas";
    filtros.corBrinco = "todas";
    filtros.prenha = "todas";
    renderFiltros(listaDoLote);
    renderOvelhas(listaDoLote);
  });
}

function aplicarFiltros(lista) {
  return lista.filter(o => {
    if (filtros.sexo      !== "todos"     && o.sexo      !== filtros.sexo)      return false;
    if (filtros.raca      !== "todas"     && o.raca      !== filtros.raca)      return false;
    if (filtros.corBrinco !== "todas"     && o.corBrinco !== filtros.corBrinco) return false;
    if (filtros.prenha    === "prenha"    && !o.prenha)                         return false;
    if (filtros.prenha    === "naoprenha" && o.prenha)                          return false;
    return true;
  });
}

// ── Renderização das ovelhas (separada para re-render ao filtrar) ─────────────
function renderOvelhas(listaDoLote) {
  const grid     = document.getElementById("ovelhasGrid");
  const filtrada = aplicarFiltros(listaDoLote);

  // Re-renderiza a barra para atualizar o contador
  renderFiltros(listaDoLote);

  if (filtrada.length === 0) {
    grid.innerHTML = `<p class="muted">Nenhuma ovelha corresponde aos filtros aplicados.</p>`;
    return;
  }

  grid.innerHTML = filtrada.map((o) => {
    const cor = corBrincoInfo(o.corBrinco);
    const dotCor = cor
      ? `<span class="ovelha-card__brinco-dot" style="background:${cor.hex}" title="Brinco ${cor.label}"></span>`
      : "";
    return `
      <button class="ovelha-card" data-id="${o.id}">
        <div class="ovelha-card__avatar">
          ${o.sexo === "Macho" ? "♂" : "♀"}
          ${o.prenha ? '<span class="ovelha-card__prenha-dot" title="Prenha">🤰</span>' : ""}
        </div>
        <div class="ovelha-card__info">
          <div class="ovelha-card__codigo">#${o.codigo} ${dotCor}</div>
          <div class="ovelha-card__sub">${o.raca} · ${o.sexo}</div>
        </div>
      </button>
    `;
  }).join("");

  grid.querySelectorAll(".ovelha-card").forEach((el) =>
    el.addEventListener("click", () => abrirModalDetalhes(+el.dataset.id))
  );
}

// ── Seção de ovelhas ─────────────────────────────────────────────────────────
function abrirLote(id) {
  loteAtivo = id;
  const lote = LOTES.find((l) => l.id === id);
  if (!lote) return;

  // Reseta filtros ao trocar de lote
  filtros.sexo = "todos";
  filtros.raca = "todas";
  filtros.corBrinco = "todas";
  filtros.prenha = "todas";

  document.getElementById("loteTitulo").textContent = lote.nome;

  const lista = OVELHAS.filter((o) => o.lote === id);

  renderFiltros(lista);
  renderOvelhas(lista);

  const sec = document.getElementById("ovelhasSection");
  sec.classList.remove("ovelhas-section--hidden");
  sec.scrollIntoView({ behavior: "smooth", block: "start" });
}

// ── Botões fixos da página ───────────────────────────────────────────────────
document.getElementById("btnCriarLote").addEventListener("click", abrirModalCriarLote);
document.getElementById("btnAddOvelha").addEventListener("click", abrirModalAddOvelha);
document.getElementById("btnVoltar").addEventListener("click", () => {
  document.getElementById("ovelhasSection").classList.add("ovelhas-section--hidden");
  loteAtivo = null;
  window.scrollTo({ top: 0, behavior: "smooth" });
});

// ── Init ─────────────────────────────────────────────────────────────────────
renderLotes();
