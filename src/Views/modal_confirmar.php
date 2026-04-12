<div id="modal-confirmar" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.4);
    z-index:9999;
    justify-content:center;
    align-items:center;
">
    <div style="
        background: var(--app-surface, #ffffff);
        border-radius:16px;
        padding:30px;
        width:350px;
        text-align:center;
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        border: 1px solid var(--app-accent, #00ffa3); 
    ">
        <p id="modal-mensagem" style="color: var(--app-text, #1f2937); font-size:1rem; margin-bottom:24px; font-weight:500;"></p>
        <div style="display:flex; gap:10px; justify-content:center;">
            <button id="modal-cancelar" style="padding:10px 25px; border-radius:8px; border: 1px solid var(--app-border, #ddd); background:transparent; color: var(--app-text, #333); cursor:pointer; font-size:1rem;">Cancelar</button>
            <button id="modal-confirmar-btn" style="padding:10px 25px; border-radius:8px; border:none; background:var(--app-danger, #ff4757); color:white; cursor:pointer; font-size:1rem;">Excluir</button>
        </div>
    </div>
</div>