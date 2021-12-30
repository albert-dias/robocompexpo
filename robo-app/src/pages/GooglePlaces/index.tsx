import React from 'react';
import { View } from 'react-native';
import { GooglePlacesAutocomplete } from 'react-native-google-places-autocomplete';

export function GooglePlaces() {
    let apiKey = 'AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y';

    return (
        <View>
            <GooglePlacesAutocomplete
                placeholder='Search'
                onPress={(data, details = null) => {
                    // 'details' is provided when fetchDetails = true
                    console.log('DATA: '+ data, 'DETALHES: '+ details);
                }}
                query={{
                    key: apiKey,
                    language: 'pt-BR',
                }}
            />
        </View>
    );
};
