// whatsapp.js — robust version that always pulls latest selected type/price from Alpine store
(function () {
    "use strict";

    // Utilities
    function sanitizeNumber(n) {
        if (n === null || n === undefined) return "";
        return String(n).replace(/[^0-9]/g, "");
    }

    function parseNumber(n) {
        if (n === null || n === undefined || n === "" || n === "null" || n === "-") return null;
        const digits = sanitizeNumber(n);
        if (!digits) return null;
        const num = Number(digits);
        return isNaN(num) ? null : num;
    }

    function getGreeting() {
        const h = new Date().getHours();
        if (h < 12) return "Selamat Pagi";
        if (h < 15) return "Selamat Siang";
        if (h < 19) return "Selamat Sore";
        return "Selamat Malam";
    }

    // Pull latest selected type & price from Alpine store (if available)
    function getSelectedFromAlpine() {
        try {
            const A = window.Alpine;
            if (!A || !A.store) return null;
            const store = A.store("product");
            if (!store) return null;
            // Prefer selectedType; if empty, fallback to first type (if exists)
            let sel = store.selectedType || null;
            if ((!sel || typeof sel !== "object") && Array.isArray(store.types) && store.types.length > 0) {
                sel = store.types[0];
            }
            return sel || null;
        } catch (err) {
            return null;
        }
    }

    function openWhatsAppFromButton(btn) {
        // Fallbacks from dataset (Blade values)
        const productName = btn?.dataset?.produk || "-";
        const basePrice = parseNumber(btn?.dataset?.harga);
        const baseUkuran = (btn?.dataset?.ukuran && btn.dataset.ukuran !== "null") ? btn.dataset.ukuran : "";
        const link = btn?.dataset?.link || window.location.href;
        const waRaw = btn?.dataset?.wa || "";
        const wa = sanitizeNumber(waRaw);

        // Pull latest selection from Alpine store
        const sel = getSelectedFromAlpine();
        const hargaSelected = sel && sel.harga != null ? parseNumber(sel.harga) : null;
        const ukuranSelected =
            sel && (sel.type || sel.ukuran) ? String(sel.type || sel.ukuran) : "";

        // Final values with fallback
        const finalHarga = (hargaSelected != null ? hargaSelected : basePrice);
        const finalUkuran = (ukuranSelected || baseUkuran || "");

        // Build message
        const parts = [];
        parts.push(`${getGreeting()}, saya ingin bertanya terkait produk ini:\n`);
        parts.push(`- Nama Produk: ${productName}`);
        if (finalUkuran) parts.push(`- Ukuran/Type: ${finalUkuran}`);
        if (finalHarga != null) parts.push(`- Harga: Rp ${Number(finalHarga).toLocaleString("id-ID")}`);
        const message = `${parts.join("\n")}\n\n${link}`;

        const url = `https://wa.me/${wa}?text=${encodeURIComponent(message)}`;
        window.open(url, "_blank");
    }

    // Event listener (delegate-safe if element is recreated)
    document.addEventListener("DOMContentLoaded", function () {
        const btn = document.getElementById("btnHubungiSales");
        if (!btn) return;
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            openWhatsAppFromButton(btn);
        });
    });
})();
