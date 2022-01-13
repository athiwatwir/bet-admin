<div class="input-group-over position-realtive z-index-1 bg-white">
    <input type="text" name="{{ $name }}" class="form-control bg-transparent datepicker" 
            data-today-highlight="true" 
            data-layout-rounded="true" 
            data-title="" 
            data-show-weeks="true" 
            data-today-highlight="true" 
            data-today-btn="true" 
            data-autoclose="true" 
            data-format="MM/DD/YYYY"
            data-quick-locale='{
                "days": ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"],
                "daysShort": ["อ.", "จ.", "อา.", "พ.", "พฤ.", "ศ.", "ส."],
                "daysMin": ["อ.", "จ.", "อา.", "พ.", "พฤ.", "ศ.", "ส."],
                "months": ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
                "monthsShort": ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
                "today": "วันนี้",
                "clear": "ล้างค่า",
                "titleFormat": "MM yyyy"}'
                required
            autocomplete="off">

    <span class="fi fi-calendar fs--20 ml-4 mr-4 z-index-n1 text-muted"></span>
</div>