document.addEventListener('alpine:init', () => {
    
    // Caption Generator Logic
    Alpine.data('captionGenerator', () => ({
        form: {
            product: '',
            business_type: '',
            target: '',
            platform: 'Instagram',
            tone: 'Casual & Fun'
        },
        loading: false,
        result: '',
        copied: false,

        async generateCaption() {
            if (!this.form.product) {
                alert('Mohon isi nama produk!');
                return;
            }

            this.loading = true;
            this.result = '';
            this.copied = false;

            try {
                const response = await fetch(semestaAiData.apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': semestaAiData.nonce
                    },
                    body: JSON.stringify({
                        type: 'caption',
                        ...this.form
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.result = data.data;
                } else {
                    alert('Error: ' + (data.message || 'Gagal membuat caption.'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi.');
            } finally {
                this.loading = false;
            }
        },

        copyToClipboard() {
            if (!this.result) return;
            navigator.clipboard.writeText(this.result).then(() => {
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            });
        }
    }));

    // HPP Calculator Logic
    Alpine.data('hppCalculator', () => ({
        form: {
            material: 0,
            production: 0,
            packaging: 0,
            operational: 0,
            profit_percent: 30
        },

        calculateHPP() {
            return (this.form.material || 0) + 
                   (this.form.production || 0) + 
                   (this.form.packaging || 0) + 
                   (this.form.operational || 0);
        },

        calculatePrice() {
            const hpp = this.calculateHPP();
            const profit = (hpp * (this.form.profit_percent || 0)) / 100;
            return hpp + profit;
        },

        calculateMargin() {
            return this.calculatePrice() - this.calculateHPP();
        },

        formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        },

        exportToPDF() {
            const element = document.getElementById('hpp-calculator-card');
            window.html2canvas(element).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF();
                
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                
                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save('HPP-Calculator-SemestaAI.pdf');
            });
        },

        exportToPNG() {
            const element = document.getElementById('hpp-calculator-card');
            window.html2canvas(element).then(canvas => {
                const link = document.createElement('a');
                link.download = 'HPP-Calculator-SemestaAI.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        }
    }));
});
