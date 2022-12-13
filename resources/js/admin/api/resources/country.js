import HttpClient from '../index'

class CountryApi extends HttpClient {
    getCountries(page = 1) {
        return this.requestType('get').request(`/countries?page=${page}`)
    }

    getCountryDetails(id) {
        return this.requestType('get').request(`/countries/${id}`)
    }

    save(payload) {
        return this.requestType('post').formBody(payload).request(`countries`)
    }

    update(payload, id) {
        return this.requestType('patch').formBody(payload).request(`countries/${id}`)
    }

    delete(id) {
        return this.requestType('delete').request(`countries/${id}`)
    }
}

const countryApi = new CountryApi()
export default countryApi
