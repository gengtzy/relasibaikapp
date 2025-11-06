<div>
    @if ($currentStep == 1)
        <livewire:screening.step-biodata />
    @elseif ($currentStep == 2)
        <livewire:screening.step-father />
    @elseif ($currentStep == 3)
        <livewire:screening.step-mother />
    @elseif ($currentStep == 4)
        <livewire:screening.step-other />
    @elseif ($currentStep == 5)
        <livewire:screening.step-result :resultId="$finalResultId" />
    @endif
</div>