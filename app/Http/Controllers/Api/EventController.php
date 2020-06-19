<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\EventStoreRequest;
use App\Http\Resources\Api\Event\EventJsonResource;
use App\Http\Resources\Api\Event\EventResource;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class EventController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $events = new EventResource(
            Event::query()
                ->when(request()->has("userEvents"), function (Builder $query) {
                    $query->whereHas("participants", function (Builder $query) {
                        $query->where("alumnus_id", auth()->id());
                    });
                })
                ->paginate(10)
        );
        return $this->successResponse(["events" => $events]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventStoreRequest $request
     * @return Response
     * @throws Throwable
     */
    public function store(EventStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            /** @var Event $event */
            $event = Event::query()->create($request->all());
            $event->addMediaFromRequest("image")
                ->preservingOriginal()
                ->toMediaCollection("cover");
            return $this->createResponse($event);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return JsonResponse
     */
    public function show(Event $event)
    {
        request()->merge(["show" => true]);
        $event = new EventJsonResource($event);
        return $this->successResponse(["event" => $event]);
    }

}
