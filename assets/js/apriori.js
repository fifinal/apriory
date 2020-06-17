class Apriori {
	constructor(transaksi, minFrekuensi) {
		this.transaksi = transaksi;
		this.minFrekuensi = minFrekuensi;
		this.nTransaksi = Object.entries(this.transaksi).length;
		this.confident = 50;
		this.itemSet = [];
		this.rule = [];
	}

	prosess() {
		$("#log").append(`<p>Menghitung itemset 1...</p>`);
		setTimeout(() => {
			this.item1();
			$("#log").append(`<p>Menghitung itemset 2...</p>`);
			setTimeout(() => {
				$("#log").append(`<p>Menghitung itemset 3...</p>`);
				this.item2();
				setTimeout(() => {
					this.item3();
					this.setRule();
					$("#overlay").hide();
				}, 100);
			}, 100);
		}, 100);
	}

	getFrekuensi(kombinasi) {
		let frekuensi = 0;
		for (let [key, value] of Object.entries(this.transaksi)) {
			let hasilKombinasi = kombinasi.filter((val, i) => value.includes(val));
			if (hasilKombinasi.length == kombinasi.length) frekuensi++;
		}
		return frekuensi;
	}

	confident(frekuensi, kombinasi) {
		return ((frekuensi / this.getFrekuensi(kombinasi)) * 100).toFixed(2);
	}

	support(frekuensi) {
		return ((frekuensi / this.nTransaksi) * 100).toFixed(2);
	}

	item1() {
		let uniqueItem = new Set();
		let itemSet = [];

		for (let [key, values] of Object.entries(this.transaksi))
			uniqueItem.add(...values);

		itemSet = Array.from(uniqueItem)
			.map((currentVal) => ({
				items: currentVal,
				frekuensi: this.getFrekuensi([currentVal]),
			}))
			.filter((val, i) => val.frekuensi > this.minFrekuensi);

		if (itemSet.length > 0) this.itemSet = itemSet;

		console.log(this.itemSet);
	}

	item2() {
		let itemSet = [];
		for (let i = 0; i < this.itemSet.length; i++) {
			for (let j = i + 1; j < this.itemSet.length; j++) {
				let items = [this.itemSet[i].items, this.itemSet[j].items];
				let frekuensi = this.getFrekuensi(items);
				if (frekuensi > 5) {
					itemSet.push({
						items,
						frekuensi,
					});
				}
			}
		}

		if (itemSet.length > 0) this.itemSet = itemSet;
		console.log(this.itemSet);
	}

	item3() {
		let itemSet3 = [];
		for (let i = 0; i < this.itemSet.length; i++) {
			for (let j = i + 1; j < this.itemSet.length; j++) {
				if (this.itemSet[i].items[0] == this.itemSet[j].items[0]) {
					let items = [...this.itemSet[i].items, this.itemSet[j].items[1]];
					let frekuensi = this.getFrekuensi(items);
					if (frekuensi > 5) {
						itemSet3.push({
							items,
							frekuensi,
						});
					}
				}
			}
		}

		if (itemSet3.length > 0) this.itemSet = itemSet3;
		console.log(this.itemSet);
	}

	getRule() {
		return this.rule;
	}

	setRule() {
		for (let i = 0; i < this.itemSet.length; i++) {
			let arrItems = this.itemSet[i].items;
			for (let j = 0; j < arrItems.length; j++) {
				for (let k = j + 1; k < arrItems.length; k++) {
					let items = [arrItems[j], arrItems[k]];
					this.addRule([items[0]], [items[1]]);
				}
			}
			for (let j = 0; j < arrItems.length; j++) {
				let k = j + 1;
				let l = k + 1;
				if (k == arrItems.length - 1) l = 0;
				if (k == arrItems.length) {
					k = 0;
					l = 1;
				}
				this.addRule([arrItems[j], arrItems[k]], [arrItems[l]]);
			}
		}
		console.log(this.rule);
		this.ruleFilter();

		$("#card-rule").show();
		this.dataTable();
	}

	ruleFilter() {
		this.rule = this.rule
			.map((val, i) => {
				let frekuensi = this.getFrekuensi([...val.if, ...val.then]);
				let support = this.support(frekuensi);
				let confident = this.confident(frekuensi, val.if);
				return {
					if: val.if.join(","),
					then: val.then.join(","),
					support,
					confident,
				};
			})
			.filter((data) => data.confident > this.confident);
		console.log(this.rule);
	}

	addRule(fst, sc) {
		this.rule.push({
			if: fst,
			then: sc,
		});
		this.rule.push({
			if: sc,
			then: fst,
		});
	}

	dataTable() {
		$("#rule").DataTable({
			data: this.rule,
			columns: [
				{
					data: "id",
					render: function (data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					},
				},
				{
					data: "if",
				},
				{
					data: "then",
				},
				{
					data: "support",
				},
				{
					data: "confident",
				},
			],
			dom: "Bfrtip",
			buttons: ["excel", "pdf"],
		});

		const pdf = document.querySelector(".buttons-pdf");
		const excel = document.querySelector(".buttons-excel");
		pdf.classList = "btn btn-sm btn-danger";
		pdf.innerHTML = `<i class="fa fa-download"></i>Download PDF`;
		excel.classList = "btn btn-sm btn-success";
		excel.innerHTML = `<i class="fa fa-download"></i>Download Excel`;
	}
}
