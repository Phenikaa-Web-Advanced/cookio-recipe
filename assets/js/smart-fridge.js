const picker = document.querySelector('#ingredientPicker');
const resultCards = [...document.querySelectorAll('.fridge-recipe')];
const message = document.querySelector('#fridgeMessage');
const noMatchBox = document.querySelector('#noMatchMessage');
const customInput = document.querySelector('#customIngredientInput');
const btnAdd = document.querySelector('#btnAddIngredient');
const btnClearAll = document.querySelector('#btnClearAll');
const customGroup = document.querySelector('#customGroup');
const customChips = document.querySelector('#customChips');

// Bảng từ đồng nghĩa & biến thể nguyên liệu tiếng Việt phong phú để liên kết dữ liệu chuẩn 100%
const KEYWORD_ALIASES = {
    'thịt bò': ['thịt bò', 'bò', 'bắp bò', 'gân bò', 'thăn bò', 'nạm bò'],
    'thịt gà': ['thịt gà', 'gà', 'ức gà', 'cánh gà', 'đùi gà', 'lòng gà', 'chân gà'],
    'thịt heo': ['thịt heo', 'heo', 'thịt lợn', 'lợn', 'ba chỉ', 'sườn', 'sườn non', 'cốt lết', 'lòng heo', 'thịt nạc', 'bì heo', 'chả'],
    'tôm': ['tôm', 'tép', 'tôm sú', 'tôm rim'],
    'cá': ['cá', 'cá lóc', 'cá bống', 'cá hồi', 'cá hú'],
    'cà chua': ['cà chua', 'sốt cà'],
    'hành tây': ['hành tây', 'hành'],
    'rau xanh': ['rau', 'cải', 'cải chua', 'mồng tơi', 'rau đay', 'bắp cải', 'bông cải', 'hoa thiên lý', 'xà lách', 'hành lá', 'ngò'],
    'cà rốt': ['cà rốt'],
    'nấm': ['nấm', 'nấm hương', 'nấm đông cô', 'nấm rơm', 'mộc nhĩ'],
    'trứng': ['trứng', 'trứng gà', 'trứng vịt', 'trứng cút'],
    'đậu phụ': ['đậu phụ', 'đậu hũ', 'tàu hũ'],
    'tỏi': ['tỏi', 'tỏi băm'],
    'gừng': ['gừng', 'gừng tươi'],
    'sả': ['sả', 'củ sả'],
    'tiêu': ['tiêu', 'hạt tiêu'],
    'ớt': ['ớt', 'sa tế', 'ớt bột'],
    'lá chanh': ['lá chanh', 'chanh', 'nước cốt chanh', 'tắc', 'quất']
};

function getMatchMode() {
    const checkedRadio = document.querySelector('input[name="match_mode"]:checked');
    return checkedRadio ? checkedRadio.value : 'any';
}

function cardMatchesIngredient(card, item) {
    const title = (card.dataset.title || '').toLowerCase();
    const ingredients = (card.dataset.ingredients || '').toLowerCase();
    const category = (card.dataset.category || '').toLowerCase();
    const desc = (card.dataset.description || '').toLowerCase();
    const fullText = `${title} ${ingredients} ${category} ${desc}`;

    const normalizedItem = item.trim().toLowerCase();
    const aliases = KEYWORD_ALIASES[normalizedItem] || [normalizedItem];

    return aliases.some(alias => fullText.includes(alias.toLowerCase()));
}

function filterRecipes() {
    const selected = [...picker.querySelectorAll('input:checked')].map((input) => input.value.trim().toLowerCase());
    const mode = getMatchMode();
    let visibleCount = 0;

    resultCards.forEach((card) => {
        const badgeContainer = card.querySelector('.match-badge-container');

        if (selected.length === 0) {
            card.classList.remove('hidden');
            if (badgeContainer) badgeContainer.innerHTML = '';
            visibleCount++;
            return;
        }

        // Đếm số lượng nguyên liệu khớp dựa trên từ điển đồng nghĩa & dữ liệu món ăn
        let matchedCount = 0;
        selected.forEach((item) => {
            if (cardMatchesIngredient(card, item)) {
                matchedCount++;
            }
        });

        const isMatch = (mode === 'all') 
            ? (matchedCount === selected.length)
            : (matchedCount > 0);

        card.classList.toggle('hidden', !isMatch);

        if (isMatch) {
            visibleCount++;
            if (badgeContainer) {
                const isFull = matchedCount === selected.length;
                const bgStyle = isFull ? 'background:#dcfce7; color:#15803d; border:1px solid #86efac;' : 'background:#fff7ed; color:#ea580c; border:1px solid #fed7aa;';
                badgeContainer.innerHTML = `<span style="display:inline-block; font-size:0.78rem; font-weight:700; ${bgStyle} padding:0.25rem 0.75rem; border-radius:99px;">Khớp ${matchedCount}/${selected.length} nguyên liệu</span>`;
            }
        } else {
            if (badgeContainer) badgeContainer.innerHTML = '';
        }
    });

    if (selected.length === 0) {
        if (message) {
            message.textContent = `Hiển thị toàn bộ ${visibleCount} món ăn trong kho Cookio. Hãy tích chọn nguyên liệu ở trên để lọc món!`;
            message.className = 'notice';
        }
        if (noMatchBox) noMatchBox.classList.add('hidden');
    } else {
        if (message) {
            const modeText = mode === 'all' ? 'khớp trọn vẹn tất cả' : 'chứa ít nhất một';
            message.textContent = `Tìm thấy ${visibleCount} món ${modeText} nguyên liệu bạn đã chọn.`;
            message.className = visibleCount > 0 ? 'notice success' : 'notice';
        }
        if (noMatchBox) {
            noMatchBox.classList.toggle('hidden', visibleCount > 0);
        }
    }
}

function addCustomIngredient() {
    const val = customInput?.value.trim();
    if (!val) return;

    // Check if already exists
    const existing = [...picker.querySelectorAll('input')].some(
        (input) => input.value.toLowerCase() === val.toLowerCase()
    );

    if (existing) {
        if (window.showToast) {
            window.showToast('Nguyên liệu này đã có trong danh sách!', 'info');
        } else {
            alert('Nguyên liệu này đã có trong danh sách!');
        }
        customInput.value = '';
        return;
    }

    if (customGroup) customGroup.classList.remove('hidden');

    const label = document.createElement('label');
    label.className = 'fridge-chip';
    label.innerHTML = `<input type="checkbox" value="${val}" checked><span>${val}</span>`;
    
    if (customChips) {
        customChips.appendChild(label);
        label.querySelector('input').addEventListener('change', filterRecipes);
    }

    customInput.value = '';
    filterRecipes();
}

function clearAllSelections() {
    [...picker.querySelectorAll('input:checked')].forEach((input) => {
        input.checked = false;
    });
    filterRecipes();
}

// Event Listeners
picker?.addEventListener('change', (e) => {
    if (e.target.matches('input[type="checkbox"]')) {
        filterRecipes();
    }
});

document.querySelectorAll('input[name="match_mode"]').forEach((radio) => {
    radio.addEventListener('change', filterRecipes);
});

btnAdd?.addEventListener('click', addCustomIngredient);
btnClearAll?.addEventListener('click', clearAllSelections);

customInput?.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault();
        addCustomIngredient();
    }
});

// Chạy lần đầu khi trang tải xong
filterRecipes();
