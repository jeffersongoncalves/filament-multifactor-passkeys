import {
    startAuthentication,
    startRegistration,
} from '@simplewebauthn/browser'

window.FilamentMultiFactorPasskeys = {
    startRegistration,
    startAuthentication,
}
