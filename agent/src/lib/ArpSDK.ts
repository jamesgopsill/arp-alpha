import { IPrint } from './IPrint'
import fetch from 'node-fetch'

export class ArpSDK {
	public printerID: string
	public apiURL: string

	/**
	 * Initialises the ARP SDK for the printer to use
	 * @param printerID - The uuid of the printer
	 * @param apiURL - The url to the printer service
	 */
	constructor(printerID: string, apiURL: string) {
		this.printerID = printerID
		this.apiURL = apiURL
	}

	/**
	 * Get the current list of queued prints from the server
	 * @returns A list of print objects.
	 */
	public async getQueuedPrints() {
		let queue: IPrint[] = []

		await fetch(this.apiURL + 'api/get-queued-prints.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({
				printer_id: this.printerID
			})
		})
			.then(async (res) => {
				if (res.status == 200) {
					const data = await res.json()
					queue = data.queue
				} else {
					console.error(res)
				}
			})
			.catch((err) => console.error(err))

		return queue
	}

	/**
	 * Get the list of prints that have been selected by the printer
	 * @returns A list of print objects.
	 */
	public async getSelectedPrints() {
		let queue: IPrint[] = []
		await fetch(this.apiURL + 'api/get-selected-prints.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({
				printer_id: this.printerID
			})
		})
			.then(async (res) => {
				if (res.status == 200) {
					const data = await res.json()
					console.log(data)
					queue = data.queue
				} else {
					console.error(res)
				}
			})
			.catch((err) => {
				throw new Error(err)
			})
		return queue
	}

	/**
	 * Gets the gcode for a print
	 * @param printID - The uuid for the print
	 * @returns Returns the decoded gcode.
	 */
	public async getGCode(printID: string) {
		console.log('Getting G-Code for:', printID)
		let gcode: string = ''
		await fetch(this.apiURL + 'gcode/' + printID + '.gcode', { method: 'GET' })
			.then(async (res) => {
				if (res.status == 200) {
					gcode = await res.text()
				} else {
					console.error(res)
				}
			})
			.catch((err) => {
				throw new Error(err)
			})
		return gcode
	}

	/**
	 * Update the status of the printer
	 * @param status - Update the status of the printer
	 * @returns
	 */
	public async updatePrinterStatus(status: string) {
		let success = false
		await fetch(this.apiURL + 'api/update-printer-status.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({
				printer_id: this.printerID,
				status: status
			})
		})
			.then(async (res) => {
				if (res.status == 200) {
					success = true
				} else {
					success = false
				}
			})
			.catch((err) => {
				throw new Error(err)
			})
		return success
	}

	/**
	 * Select the print for your printer
	 * @returns Boolean
	 */
	public async selectPrint(printID: string) {
		let success = false
		await fetch(this.apiURL + 'api/select-print.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({
				printer_id: this.printerID,
				print_id: printID
			})
		})
			.then(async (res) => {
				if (res.status == 200) {
					success = true
				} else {
					success = false
					console.error(res)
				}
			})
			.catch((err) => {
				throw new Error(err)
			})
		return success
	}

	/**
	 * Select the print for your printer
	 * @returns
	 */
	public async printComplete(printID: string) {
		let success = false
		await fetch(this.apiURL + 'api/print-complete.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({
				printer_id: this.printerID,
				print_id: printID
			})
		})
			.then(async (res) => {
				if (res.status == 200) {
					success = true
				} else {
					success = false
					console.error(res)
				}
			})
			.catch((err) => {
				throw new Error(err)
			})
		return success
	}
}
